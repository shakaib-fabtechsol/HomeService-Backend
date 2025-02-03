<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function BasicInfo(Request $request){
        Deal::create($request->all());
        return response()->json(['message' => 'Added new deal successfully'], 200);
    }

    public function PriceAndPackage(Request $request){
        Deal::create($request->all());
        return response()->json(['message' => 'Added new package deal successfully'], 200);
    }

    public function MediaUpload(Request $request){
        if ($request->hasFile('image')) {
            $photo1 = $request->file('image');

            $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
            $photo_destination = public_path('uploads');
            $photo1->move($photo_destination, $photo_name1);
            $data['image'] = $photo_name1;
            Deal::create($data);
            return response()->json(['message' => 'Added new deal with Image successfully'], 200);
        } else{
            return response()->json(['message' => 'image field required'], 422);
        }
    }
}
