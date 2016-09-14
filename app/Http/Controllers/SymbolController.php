<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Services\PortValue;
use App\StockSymbol;
use App\StockTransaction;
use App\UserPort;
use App\Setting;
use App\User;

class SymbolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List all stock.
     *
     * @param \App\StockSymbol $symbol
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $stocks = StockSymbol::all();
        return view('symbol-list', compact('stocks'));
    }

    /**
     * Show stock symbol.
     *
     * @param \App\StockSymbol $symbol
     * @return \Illuminate\Http\Response
     */
    public function symbol (StockSymbol $symbol)
    {
        if ($symbol->is_suspended) {
            return 'การซื้อขายถูกระงับ';
        } else {
            $own = UserPort::where([
                    ['user_id', Auth::user()->id],
                    ['symbol', $symbol->symbol]
            ])->first();
            $fee = floatval(Setting::key('fee'));
            $tax = floatval(Setting::key('tax'));
            $cash = User::where('id', Auth::user()->id)->first()->cash;
            return view('symbol', compact('symbol', 'own', 'fee', 'tax', 'cash'));
        }
    }

    /**
     * Buy stock.
     *
     * @param \App\StockSymbol $symbol
     * @return \Illuminate\Http\Response
     */
    public function buy (Request $request, StockSymbol $symbol)
    {
        // Validate
        if ($symbol->is_suspended) return 'การซื้อขายถูกระงับ';
        if ($symbol->close_price < 10) {
            return redirect('symbol/'.$symbol->symbol)->withErrors(['buy' => 'ราคาหุ้น ณ วันที่ซื้อ ต้องไม่ต่ำกว่า 10 บาท']);
        }
        if ($request->input('buy_volume') % 100 != 0) {
            return redirect('symbol/'.$symbol->symbol)->withErrors(['buy_volume' => 'ต้องเป็นจำนวนเท่าของ 100']);
        }

        $validator = Validator::make($request->all(), [
            'buy_volume' => 'bail|required|numeric|min:100'
        ]);
        $validator->validate();

        $volume = intval($request->input('buy_volume'));
        $cost = $volume * $symbol->close_price;

        if ($cost < 10000) {
            return redirect('symbol/'.$symbol->symbol)->withErrors(['buy' => 'มูลค่าต้องไม่ต่ำกว่า 10,000 บาท']);
        }
        // end validate

        $fee_rate = floatval(Setting::key('fee')) / 100;
        $tax_rate = floatval(Setting::key('tax')) / 100;
        $cost = round($cost, 2);
        $fee = round($cost * $fee_rate, 2);
        $tax = round($fee * $tax_rate, 2);
        $total = round($cost + $fee + $tax, 2);

        $user_id = Auth::user()->id;

        DB::beginTransaction();
        try {
            User::where('id', $user_id)->decrement('cash', $total);
            if (User::where('id', $user_id)->first()->cash < 0) {
                DB::rollBack();
                $validator->messages()->add('buy_volume', 'เงินสดไม่พอ');
                return redirect('symbol/'.$symbol->symbol)->withErrors($validator);
            } else {
                if (!UserPort::where([['user_id', $user_id],['symbol' , $symbol->symbol]])->first()) {
                    UserPort::insert([
                        'user_id' => $user_id,
                        'symbol' => $symbol->symbol,
                        'volume' => 0
                    ]);
                }
                UserPort::where([
                    ['user_id', $user_id],
                    ['symbol' , $symbol->symbol]
                ])->increment('volume', $volume);
                $transaction = new StockTransaction;
                $transaction->user_id = $user_id;
                $transaction->symbol = $symbol->symbol;
                $transaction->type = 'buy';
                $transaction->volume = $volume;
                $transaction->cost = $cost;
                $transaction->fee = $fee;
                $transaction->tax = $tax;
                $transaction->total = $total;
                $transaction->save();

                DB::commit();
                PortValue::update($user_id);
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return redirect('symbol/'.$symbol->symbol);
    }

    /**
     * Sell stock.
     *
     * @param \App\StockSymbol $symbol
     * @return \Illuminate\Http\Response
     */
    public function sell (Request $request, StockSymbol $symbol)
    {
        // validate
        if ($symbol->is_suspended) return 'การซื้อขายถูกระงับ';
        if ($request->input('sell_volume') % 100 != 0) {
            return redirect('symbol/'.$symbol->symbol)->withErrors(['sell_volume' => 'ต้องเป็นจำนวนเท่าของ 100']);
        }

        $validator = Validator::make($request->all(), [
            'sell_volume' => 'bail|required|numeric|min:100'
        ]);
        $validator->validate();

        $volume = intval($request->input('sell_volume'));
        $cost = $volume * $symbol->close_price;
        if ($cost < 10000) {
            return redirect('symbol/'.$symbol->symbol)->withErrors(['sell' => 'มูลค่าต้องไม่ต่ำกว่า 10,000 บาท']);
        }
        // end validate
        $own = UserPort::where([
                ['user_id', Auth::user()->id],
                ['symbol', $symbol->symbol]
        ])->first()->volume;
        $fee_rate = floatval(Setting::key('fee')) / 100;
        $tax_rate = floatval(Setting::key('tax')) / 100;
        $cost = round($cost, 2);
        $fee = round($cost * $fee_rate, 2);
        $tax = round($fee * $tax_rate, 2);
        $total = round($cost - $fee - $tax, 2);

        $user_id = Auth::user()->id;

        DB::beginTransaction();
        try {
            if ($volume > $own) {
                $validator->messages()->add('sell_volume', 'มากกว่าจำนวนที่มีอยู่');
                return redirect('symbol/'.$symbol->symbol)->withErrors($validator);
            } else {
                UserPort::where([
                    ['user_id', $user_id],
                    ['symbol' , $symbol->symbol,]
                ])->decrement('volume', $volume);
                User::where('id', $user_id)->increment('cash', $total);
                $transaction = new StockTransaction;
                $transaction->user_id = $user_id;
                $transaction->symbol = $symbol->symbol;
                $transaction->type = 'sell';
                $transaction->volume = $volume;
                $transaction->cost = $cost;
                $transaction->fee = $fee;
                $transaction->tax = $tax;
                $transaction->total = $total;
                $transaction->save();

                DB::commit();
                PortValue::update($user_id);
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return redirect('symbol/'.$symbol->symbol);
    }


}
