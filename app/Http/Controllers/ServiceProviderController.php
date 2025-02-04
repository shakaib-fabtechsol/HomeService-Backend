<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function Deals(Request $request){
        $deals = Deal::where('publish',1)->get();
        if($deals){
            return response()->json(['deals' => $deals], 200);
        } else{
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function DealPublish(Request $request){
        $deal = Deal::find($request->id);
        if($deal){
            $data = $request->all();
            $data['publish'] = 1;
            $deal->update($data);
            return response()->json(['message' => 'Deal Publish successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function BasicInfo(Request $request){
        $data = $request->all();
        $data['publish'] = 0;
        $deal = Deal::create($data);
        return response()->json(['message' => 'Added new deal successfully', 'deal' => $deal], 200);
    }

    public function PriceAndPackage(Request $request){
        $data = $request->all();
        $data['publish'] = 0;
        $deal = Deal::create($data);
        return response()->json(['message' => 'Added new package deal successfully', 'deal' => $deal], 200);
    }

    public function MediaUpload(Request $request){
        if ($request->hasFile('image')) {
            $photo1 = $request->file('image');

            $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
            $photo_destination = public_path('uploads');
            $photo1->move($photo_destination, $photo_name1);
            $data['image'] = $photo_name1;
            $data['publish'] = 0;
            $deal = Deal::create($data);
            return response()->json(['message' => 'Added new deal with Image successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'image field required'], 422);
        }
    }

    public function UpdateBasicInfo(Request $request){
        $deal = Deal::find($request->id);
        if($deal){
            $data = $request->all();
            if ($request->has('commercial')){
            } else{
                $data['commercial'] = null;
            }
            if ($request->has('residential')){
            } else{
                $data['residential'] = null;
            }
            $deal->update($data);
            return response()->json(['message' => 'Deal updated successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function UpdatePriceAndPackage(Request $request){
        $deal = Deal::find($request->id);
        if($deal){
            $data = $request->all();
            if ($data['pricing_model'] == 'Flat'){

                $data['hourly_rate'] = null;
                $data['discount'] = null;
                $data['hourly_final_list_price'] = null;
                $data['hourly_estimated_service_time'] = null;
                $data['title1'] = null;
                $data['deliverable1'] = null;
                $data['price1'] = null;
                $data['by_now_discount1'] = null;
                $data['final_list_price1'] = null;
                $data['estimated_service_timing1'] = null;
                $data['title2'] = null;
                $data['deliverable2'] = null;
                $data['price2'] = null;
                $data['by_now_discount2'] = null;
                $data['final_list_price2'] = null;
                $data['estimated_service_timing2'] = null;
                $data['title3'] = null;
                $data['deliverable3'] = null;
                $data['price3'] = null;
                $data['by_now_discount3'] = null;
                $data['final_list_price3'] = null;
                $data['estimated_service_timing3'] = null;

            } else if($data['pricing_model'] == 'Hourly'){
                
                $data['flat_rate_price'] = null;
                $data['flat_by_now_discount'] = null;
                $data['flat_final_list_price'] = null;
                $data['flat_estimated_service_time'] = null;
                $data['title1'] = null;
                $data['deliverable1'] = null;
                $data['price1'] = null;
                $data['by_now_discount1'] = null;
                $data['final_list_price1'] = null;
                $data['estimated_service_timing1'] = null;
                $data['title2'] = null;
                $data['deliverable2'] = null;
                $data['price2'] = null;
                $data['by_now_discount2'] = null;
                $data['final_list_price2'] = null;
                $data['estimated_service_timing2'] = null;
                $data['title3'] = null;
                $data['deliverable3'] = null;
                $data['price3'] = null;
                $data['by_now_discount3'] = null;
                $data['final_list_price3'] = null;
                $data['estimated_service_timing3'] = null;

            } else{

                $data['flat_rate_price'] = null;
                $data['flat_by_now_discount'] = null;
                $data['flat_final_list_price'] = null;
                $data['flat_estimated_service_time'] = null;
                $data['hourly_rate'] = null;
                $data['discount'] = null;
                $data['hourly_final_list_price'] = null;
                $data['hourly_estimated_service_time'] = null;

            }
            $deal->update($data);
            return response()->json(['message' => 'Deal updated successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function UpdateMediaUpload(Request $request){
        $deal = Deal::find($request->id);
        if($deal){
            $data = [];
            if ($request->hasFile('image')) {
                $imagePath = public_path('uploads/' . $deal->image);
                if (!empty($deal->image) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $photo1 = $request->file('image');
                $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                $photo_destination = public_path('uploads');
                $photo1->move($photo_destination, $photo_name1);
                $data['image'] = $photo_name1;
                $data['id'] = $request->id;
                $deal->update($data);
            }
            return response()->json(['message' => 'Image updated successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function DeleteDeal(Request $request){
        $deal = Deal::find($request->id);
        if($deal){
            $deal->delete();
            return response()->json(['message' => 'Deal deleted successfully', 'deal' => $deal], 200);
        } else{
            return response()->json(['message' => 'No deal found'], 200);
        }
    }

}
