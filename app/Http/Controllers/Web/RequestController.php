<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->requests()->with('requestItems')->paginate(10);
        return view('requests.list', compact('requests'));
    }
}
