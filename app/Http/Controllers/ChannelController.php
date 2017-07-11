<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    function store(Request $request) {
        Log::info('request', ["request" => json_encode($request)]);
        return redirect("/");
    }
}
