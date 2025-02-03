<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function addDeal(Request $request){
        return response()->json(['message' => 'Deal add successfully'], 200);
    }
}
