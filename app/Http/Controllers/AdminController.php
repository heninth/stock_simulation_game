<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\UserPort;
use App\StockTransaction;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index() {
        $users = User::get();
        return view('admin/user-list', compact('users'));
    }

    public function detail(User $user) {
        $stocks = UserPort::where([['user_id', $user->id],['volume', '>', 0]])->orderBy('symbol', 'asc')->get();
        $histories = StockTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('admin/detail', compact('user', 'stocks', 'histories'));
    }
}
