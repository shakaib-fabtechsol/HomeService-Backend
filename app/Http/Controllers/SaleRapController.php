<?php

namespace App\Http\Controllers;
use App\Models\Deal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SaleRapController extends Controller
{
    public function Dashboard(){

        $GetTotalClient=User::where('role',1)->count();
        $GetCurrentMonthTotalClient=User::where('role',1)->whereMonth('created_at', Carbon::now()->month)->count();
        
        return response()->json(['GetTotalClient' => $GetTotalClient,'GetCurrentMonthTotalClient' => $GetCurrentMonthTotalClient], 200);
    }
    public function SaleRepProviders()
    {
        $serviceProviders = DB::table('users')
            ->leftJoin('deals', 'users.id', '=', 'deals.user_id')
            ->select(
                'users.id',
                'users.personal_image',
                'users.name',
                'users.email',
                'users.phone',
                DB::raw('COUNT(deals.id) as total_deals')
            )
            ->where('users.role', 2)
            ->groupBy('users.id', 'users.personal_image', 'users.name', 'users.email', 'users.phone')
            ->get();

        if ($serviceProviders) {
            return response()->json(['serviceProviders' => $serviceProviders], 200);
        } else {
            return response()->json(['message' => 'No Service Provider Available'], 200);
        }
    }


}