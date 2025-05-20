<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\Iso37001;
use Illuminate\Support\Facades\Auth;

class Iso37001Controller extends Controller
{
    public function index()
    {
        $acces = Auth::user()->type;
        // dd($acces);

        $accesArray = json_decode($acces, true) ?? [];

        $divisi = Divisi::whereIn('id', $accesArray)
        ->orderBy('nama_divisi', 'asc')
        ->get();
        // $divisi = Divisi::whereIn('id',$acces)->get();

        return view('iso37001.index', compact('divisi'));
    }
}
