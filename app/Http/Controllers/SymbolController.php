<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\StockSymbol;

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
     * Show the application dashboard.
     *
     * @param \App\StockSymbol $symbol
     * @return \Illuminate\Http\Response
     */
    public function index (StockSymbol $symbol)
    {
        $data['symbol'] = $symbol;
        return view('symbol', $data);
    }
}
