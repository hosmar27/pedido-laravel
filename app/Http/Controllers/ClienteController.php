<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = "Cliente na lista ClienteController";
        return view('clientes.index',['clientes' => $clientes]);
    }

    public function create()
    {
        return view('clientes.create');
    }
}