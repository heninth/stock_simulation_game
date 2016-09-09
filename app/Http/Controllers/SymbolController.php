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
        return view('symbol', compact('symbol'));
    }
}
