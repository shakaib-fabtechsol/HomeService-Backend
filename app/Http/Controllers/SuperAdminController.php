<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    //
    public function ServiceProviders()
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

    public function ProviderDetail($user_id)
    {
        $user = User::find($user_id);
        $deals = Deal::where('user_id', $user_id)->get();
        $business = BusinessProfile::where('user_id', $user_id)->first();
        return response()->json(['message' => 'Provider Details', 'user' => $user, 'deals' => $deals, 'business' => $business], 200);
    }

    public function Customers()
    {
        $customers = User::where('role', 1)->get();
        if ($customers) {
            return response()->json(['Customers' => $customers], 200);
        } else {
            return response()->json(['message' => 'No Customer Available'], 200);
        }
    }
}
