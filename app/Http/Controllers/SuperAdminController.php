<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class SuperAdminController extends Controller
{
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