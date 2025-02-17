<?php

namespace App\Http\Controllers;
use App\Models\Deal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SaleRapController extends Controller
{
    public function Dashboard(){

        $GetTotalClient=User::where('role',1)->count();
        $GetCurrentMonthTotalClient=User::where('role',1)->whereMonth('created_at', Carbon::now()->month)->count();
        $GetTotalActiveProvider=User::where('role',2)->count();
        $GetTotalCompletedServices=Deal::where('publish',1)->count();
       
        
        return response()->json(['GetTotalClient' => $GetTotalClient,'GetCurrentMonthTotalClient' => $GetCurrentMonthTotalClient,'GetTotalActiveProvider' => $GetTotalActiveProvider,'GetTotalCompletedServices' => $GetTotalCompletedServices], 200);
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

    public function SalesPersonal(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $data = $request->all();
            if ($request->hasFile('personal_image')) {
                $imagePath = public_path('uploads/' . $user->personal_image);
                if (!empty($user->personal_image) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $photo1 = $request->file('personal_image');
                $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                $photo_destination = public_path('uploads');
                $photo1->move($photo_destination, $photo_name1);
                $data['personal_image'] = $photo_name1;
                $user->update($data);
            }
            return response()->json(['message' => 'User Personal details updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

    public function SalesSecurity(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 200);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'User Password Updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

}