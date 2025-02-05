<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Deal;
use App\Models\User;
use App\Models\PaymentDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ServiceProviderController extends Controller
{
    public function Deals(Request $request)
    {
        $deals = Deal::orderBy('id', 'desc')->get();
        if ($deals) {
            return response()->json(['deals' => $deals], 200);
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }


    public function Deal($id){
        $deal = Deal::where('id',$id)->get();
        if($deal){

            return response()->json(['deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deal found'], 200);
        }
    }

    public function DealPublish(Request $request)
    {
        $deal = Deal::find($request->id);
        if ($deal) {
            $data = $request->all();
            $data['publish'] = 1;
            $deal->update($data);
            return response()->json(['message' => 'Deal Publish successfully', 'deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function BasicInfo(Request $request)
    {
        $data = $request->all();
        // $data['search_tags'] = !empty($request->search_tags) ? implode(',', $request->search_tags) : '';
        if (!empty($request->id)) {
            $deal = Deal::find($request->id);
            if ($deal) {
                $data = $request->all();
                if ($request->has('commercial')) {
                } else {
                    $data['commercial'] = null;
                }
                if ($request->has('residential')) {
                } else {
                    $data['residential'] = null;
                }
                $deal->update($data);
                return response()->json(['message' => 'Deal updated successfully', 'deal' => $deal], 200);
            } else {
                return response()->json(['message' => 'No deals found'], 200);
            }
        } else {
            $data['publish'] = 0;
            $deal = Deal::create($data);
            return response()->json(['message' => 'Added new deal successfully', 'deal' => $deal], 200);
        }
    }

    public function PriceAndPackage(Request $request)
    {
        $data = $request->all();

        if(!empty($request->id)){
            $deal = Deal::find($request->id);
          
            if ($deal) {
                $data = $request->all();
                if ($data['pricing_model'] == 'Flat') {
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
                } elseif ($data['pricing_model'] == 'Hourly') {
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
                } else {
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
            } else {
                return response()->json(['message' => 'No deals found'], 200);
            }

        }else{
        $data['publish'] = 0;
        $deal = Deal::create($data);
        return response()->json(['message' => 'Added new package deal successfully', 'deal' => $deal], 200);
        }
    }

    public function MediaUpload(Request $request)
    {
        if(!empty($request->id)){
            $deal = Deal::find($request->id);
            if ($deal) {
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
            } else {
                return response()->json(['message' => 'No deals found'], 200);
            }
        }else{
        if ($request->hasFile('image')) {
            $photo1 = $request->file('image');

            $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
            $photo_destination = public_path('uploads');
            $photo1->move($photo_destination, $photo_name1);
            $data['image'] = $photo_name1;
            $data['publish'] = 0;
            $deal = Deal::create($data);
            return response()->json(['message' => 'Added new deal with Image successfully', 'deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'image field required'], 422);
        }
    }
    }

    public function UpdateBasicInfo(Request $request)
    {
        $deal = Deal::find($request->id);
        if ($deal) {
            $data = $request->all();
            if ($request->has('commercial')) {
            } else {
                $data['commercial'] = null;
            }
            if ($request->has('residential')) {
            } else {
                $data['residential'] = null;
            }
            $deal->update($data);
            return response()->json(['message' => 'Deal updated successfully', 'deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function UpdatePriceAndPackage(Request $request)
    {
        $deal = Deal::find($request->id);
        if ($deal) {
            $data = $request->all();
            if ($data['pricing_model'] == 'Flat') {
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
            } elseif ($data['pricing_model'] == 'Hourly') {
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
            } else {
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
            return response()->json(['deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function UpdateMediaUpload(Request $request)
    {
        $deal = Deal::find($request->id);
        if ($deal) {
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
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }


    public function DeleteDeal($id){
        $deal = Deal::find($id);
        if($deal){

            $imagePath = public_path('uploads/' . $deal->image);
            if (!empty($deal->image) && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $deal->delete();
            return response()->json(['message' => 'Deal deleted successfully', 'deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deal found'], 200);
        }
    }

    public function MyDetails(Request $request)
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

    public function UpdatePassword(Request $request)
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


    public function BusinessProfile(Request $request){
        $user = User::find($request->user_id);
        if($user){
            $data = $request->all();
            $businessProfile = BusinessProfile::where('user_id', $user->id)->first();
            if($businessProfile){
                if ($request->hasFile('business_logo')) {
                    $imagePath = public_path('uploads/' . $businessProfile->business_logo);
                    if (!empty($businessProfile->business_logo) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $photo1 = $request->file('business_logo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['business_logo'] = $photo_name1;
                    $user->update($data);
                }
                $businessProfile->update($data);
                return response()->json(['message' => 'User Business Profile Updated successfully', 'user' => $user, 'BusinessProfile' => $businessProfile], 200);
            } else{
                if ($request->hasFile('business_logo')) {
                    $photo1 = $request->file('business_logo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['business_logo'] = $photo_name1;
                }
                $businessProfile = BusinessProfile::create($data);
            }

            return response()->json(['message' => 'User Business Profile created successfully', 'user' => $user, 'BusinessProfile' => $businessProfile], 200);
        } else{

            return response()->json(['message' => 'No user found'], 200);
        }
    }
    public function AddPaymentDetails(Request $request)
    {
        $data = $request->all();

        if (isset($request->user_id)) {
            $request['user_id'] = $request->user_id;
            $payment = PaymentDetail::create($data);
            return response()->json(['message' => 'Added Payment details successfully', 'payment' => $payment], 200);
        }

        return response()->json(['message' => 'User not found'], 200);
    }

    public function UpdatePaymentDetails(Request $request)
    {
        $payment = PaymentDetail::find($request->id);

        $data = $request->all();

        $payment->update($data);

        return response()->json(['message' => 'Updated Payment details successfully', 'payment' => $payment], 200);
    }

    public function DeletePaymentDetails($id)
    {
        $payment = PaymentDetail::find($id);
        $payment->delete();
        return response()->json(['message' => 'Deleted Payment details successfully', 'payment' => $payment], 200);
    }

    public function AdditionalPhotos(Request $request){
        $user = User::find($request->user_id);
        if($user){
            $data = $request->all();
            $businessProfile = BusinessProfile::where('user_id', $user->id)->first();
            if($businessProfile){
                if ($request->hasFile('technician_photo')) {
                    $imagePath = public_path('uploads/' . $businessProfile->technician_photo);
                    if (!empty($businessProfile->technician_photo) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $photo1 = $request->file('technician_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['technician_photo'] = $photo_name1;
                    $user->update($data);
                }
                if ($request->hasFile('vehicle_photo')) {
                    $imagePath = public_path('uploads/' . $businessProfile->vehicle_photo);
                    if (!empty($businessProfile->vehicle_photo) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $photo1 = $request->file('vehicle_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['vehicle_photo'] = $photo_name1;
                    $user->update($data);
                }
                if ($request->hasFile('facility_photo')) {
                    $imagePath = public_path('uploads/' . $businessProfile->facility_photo);
                    if (!empty($businessProfile->facility_photo) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $photo1 = $request->file('facility_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['facility_photo'] = $photo_name1;
                    $user->update($data);
                }
                if ($request->hasFile('project_photo')) {
                    $imagePath = public_path('uploads/' . $businessProfile->project_photo);
                    if (!empty($businessProfile->project_photo) && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $photo1 = $request->file('project_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['project_photo'] = $photo_name1;
                    $user->update($data);
                }
                $businessProfile->update($data);
                return response()->json(['message' => 'User Business Profile Updated successfully', 'user' => $user, 'BusinessProfile' => $businessProfile], 200);
            } else{
                if ($request->hasFile('technician_photo')) {
                    $photo1 = $request->file('technician_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['technician_photo'] = $photo_name1;
                }
                if ($request->hasFile('vehicle_photo')) {
                    $photo1 = $request->file('vehicle_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['vehicle_photo'] = $photo_name1;
                }
                if ($request->hasFile('facility_photo')) {
                    $photo1 = $request->file('facility_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['facility_photo'] = $photo_name1;
                }
                if ($request->hasFile('project_photo')) {
                    $photo1 = $request->file('project_photo');
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $data['project_photo'] = $photo_name1;
                }
                $businessProfile = BusinessProfile::create($data);
            }

            return response()->json(['message' => 'User Business Profile created successfully', 'user' => $user, 'BusinessProfile' => $businessProfile], 200);
        } else{

            return response()->json(['message' => 'No user found'], 200);
        }
    }
}
