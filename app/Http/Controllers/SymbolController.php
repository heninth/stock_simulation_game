<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\StockSymbol;
use App\UserPort;
use App\Setting;

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
            return 'Trading Suspension';
        } else {
            $own = UserPort::where('user_id', Auth::user()->id)->where('symbol', $symbol->symbol)->get();
            $fee = floatval(Setting::key('fee'));
            $tax = floatval(Setting::key('tax'));
            return view('symbol', compact('symbol', 'own', 'fee', 'tax'));
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
        $this->validate($request, [
            'buy_volumn' => 'required|numeric|min:1'
        ]);
        $fee_rate = floatval(Setting::key('fee')) / 100;
        $tax_rate = floatval(Setting::key('tax')) / 100;
        $cost = intval($request->input('buy_volumn')) * StockSymbol::where('symbol', $symbol->symbol)->first()->close_price;
        $fee = $cost * $fee_rate;
        $tax = $fee * $tax_rate;
        $total = $cost + $fee + $tax;

        if ($total > User::where('id', Auth::user()->id)->first()->cash) {

        } else {
            
        }

    }
}
