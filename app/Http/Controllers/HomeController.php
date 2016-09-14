<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserPort;
use App\StockSymbol;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $stocks = UserPort::where('user_id', $user->id)->orderBy('symbol', 'asc')->get();
        //dd($stocks[0]->symbol()->first()->);
        return view('home', compact('stocks', 'user'));
    }
}
