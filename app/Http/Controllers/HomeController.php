<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class HomeController extends Controller
{
    public function index( Request $request )
    {

        $path = storage_path('app/banktxndata/BankTransactions.csv');

        if ( ! File::exists($path) ) {
            $request->session()->forget('txnData');
        }

        return view('home', $request );
    }
}
