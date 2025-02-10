<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\SocialProfile;
class CustomerController extends Controller
{
    public function MyDetail(Request $request)
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

    public function NewPassword(Request $request)
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

    public function AddPaymentMethod(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $data = $request->all();
            $paymentMethod = PaymentMethod::create($data);
            return response()->json(['message' => 'Added New Payment Method successfully', 'user' => $user, 'Payment Method' => $paymentMethod], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

    public function DeletePaymentMethod($id){
        $paymentMethod = PaymentMethod::find($id);
        if($paymentMethod){
            $paymentMethod->delete();
            return response()->json(['message' => 'Payment Method deleted successfully', 'PaymentMethod' => $paymentMethod], 200);
        } else {
            return response()->json(['message' => 'No Payment Method found'], 200);
        }
    }

    public function UpdatePaymentMethod(Request $request){
        $paymentMethod = PaymentMethod::find($request->id);
        if($paymentMethod){
            $data = $request->all();
            $paymentMethod->update($data);
            return response()->json(['message' => 'Payment Method Updated successfully', 'PaymentMethod' => $paymentMethod], 200);
        } else {
            return response()->json(['message' => 'No Payment Method found'], 200);
        }
    }

    public function ListDeals(Request $request)
    {
        $deals = Deal::orderBy('id', 'desc')->get();
        if ($deals) {
            return response()->json(['deals' => $deals], 200);
        } else {
            return response()->json(['message' => 'No deals found'], 200);
        }
    }

    public function SingleDeal($id)
    {
        $deal = Deal::where('id', $id)->get();
        if ($deal) {
            return response()->json(['deal' => $deal], 200);
        } else {
            return response()->json(['message' => 'No deal found'], 200);
        }
    }
    public function AddSocial(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $social = SocialProfile::where('user_id', $user->id)->first();
            $data = $request->all();
            if ($social) {
                $social->update($data);
                return response()->json(['message' => 'Social Added successfully', 'user' => $user, 'Social' => $social], 200);
            } else {
                $social = SocialProfile::create($data);
            }
            return response()->json(['message' => 'Added Social successfully', 'user' => $user, 'Social' => $social], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

    public function DeleteSocial(Request $request){

        $social=SocialProfile::find($request->id);
          
        if($request['facebook'] == $social->facebook){

            $social->update(['facebook'=> null]);

        }
        if($request['twitter'] == $social->twitter){

            $social->update(['twitter'=> null]);

        }
        if($request['instagram'] == $social->instagram){

            $social->update(['instagram'=> null]);

        }
        if($request['linkedin'] == $social->linkedin){

            $social->update(['linkedin'=> null]);

        }
        if($request['youtube'] == $social->youtube){

            $social->update(['youtube'=> null]);

        }
        if($request['google_business'] == $social->google_business){

            $social->update(['google_business'=> null]);

        }
        if ($social && is_null($social->facebook) && is_null($social->twitter) && is_null($social->instagram) && is_null($social->linkedin) && is_null($social->youtube) && is_null($social->google_business)) {
            $social->delete();
        }
        return response()->json(['social' => $social], 200);


    }
}
