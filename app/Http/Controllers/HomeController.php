<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama Destinataste.
     */
    public function index()
    {
        return view('welcome');
    }
}