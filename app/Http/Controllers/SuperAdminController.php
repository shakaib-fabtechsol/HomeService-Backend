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
  public function AddSalesReps(Request $request){
      
      
        $data=$request->all();
      
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
    
    public function ViewSalesReps($id){

        $GetSalesReps=User::find($id);

        return response()->json(['GetSalesReps' => $GetSalesReps], 200);
        
    }

    public function UpdateSalesReps(Request $request){

      $data=$request->all();
      
      $GetSaleRep=User::find($request->id);
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

    public function DeleteSalesReps($id){

        $GetSaleRep=User::find($id);
        $imagePath = public_path('uploads/' . $GetSaleRep->personal_image);
        if (!empty($GetSaleRep->personal_image) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $GetSaleRep->delete();
        return response()->json(['message' => 'Sales Reps deleted successfully', 'GetSaleRep' => $GetSaleRep], 200);
    }
}
