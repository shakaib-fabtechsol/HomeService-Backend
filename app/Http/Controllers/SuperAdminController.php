<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function SuperAdminDashboard(){


        $GetNumberOfDeals=Deal::all()->count();
        $GetTotalServiceProvider=User::where('role',2)->count();
        $GetTotalClient=User::where('role',1)->count();
        dd($GetTotalClient);
        
    }
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
    public function AddSalesReps(Request $request)
    {


        $data = $request->all();

        if ($request->hasFile('personal_image')) {
            $photo1 = $request->file('personal_image');
            $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
            $photo_destination = public_path('uploads');
            $photo1->move($photo_destination, $photo_name1);
            $data['personal_image'] = $photo_name1;
        }
        $data['terms'] = 1;
        $Salesreps = User::create($data);


        return response()->json(['message' => 'Sales Reps created successfully', 'Salesreps' => $Salesreps], 200);
    }

    public function ViewSalesReps($id)
    {

        $GetSalesReps = User::find($id);

        return response()->json(['GetSalesReps' => $GetSalesReps], 200);
    }

    public function UpdateSalesReps(Request $request)
    {

        $data = $request->all();

        $GetSaleRep = User::find($request->id);
        if ($request->hasFile('personal_image')) {
            $imagePath = public_path('uploads/' . $GetSaleRep->personal_image);
            if (!empty($GetSaleRep->personal_image) && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $photo1 = $request->file('personal_image');
            $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
            $photo_destination = public_path('uploads');
            $photo1->move($photo_destination, $photo_name1);
            $data['personal_image'] = $photo_name1;
        }
        $GetSaleRep->update($data);

        return response()->json(['message' => 'Sales Reps updated successfully', 'GetSaleRep' => $GetSaleRep], 200);
    }

    public function banProvider(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->role != 2) {
            return response()->json(['message' => 'Invalid User'], 403);
        }
        $user->update(['status' => 1]);
        return response()->json(['message' => 'User banned successfully', 'user' => $user], 200);
    }
    

    public function DeleteSalesReps($id)
    {

        $GetSaleRep = User::find($id);
        $imagePath = public_path('uploads/' . $GetSaleRep->personal_image);
        if (!empty($GetSaleRep->personal_image) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $GetSaleRep->delete();
        return response()->json(['message' => 'Sales Reps deleted successfully', 'GetSaleRep' => $GetSaleRep], 200);
    }

    public function UpdatePersonal(Request $request)
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

    public function Security(Request $request)
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

    public function NotificationSetting(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $data = $request->all();
            if ($request->has('general_notification')) {
            } else {
                $data['general_notification'] = null;
            }
            if ($request->has('provider_notification')) {
            } else {
                $data['provider_notification'] = null;
            }
            if ($request->has('customer_notification')) {
            } else {
                $data['customer_notification'] = null;
            }
            if ($request->has('sales_notification')) {
            } else {
                $data['sales_notification'] = null;
            }
            if ($request->has('message_notification')) {
            } else {
                $data['message_notification'] = null;
            }
            $user->update($data);
            return response()->json(['message' => 'Notificaiton Setting Updated successfully', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }  
}