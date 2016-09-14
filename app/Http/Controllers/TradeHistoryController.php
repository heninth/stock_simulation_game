<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\StockTransaction;

class TradeHistoryController extends Controller
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
     * List all trade history.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $histories = StockTransaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('trade-history', compact('histories'));
    }

}
