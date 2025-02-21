<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use App\Models\Deal;
use App\Models\DeliveryImage;
use App\Models\Notification;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\SocialProfile;
use Illuminate\Support\Facades\Auth;

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
            }
            $user->update($data);
            $notification = [
                'title' => 'Profile Updated',
                'message' => 'Profile has been updated successfully',
                'created_by' => $user->id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
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
            $notification = [
                'title' => 'Password Updated',
                'message' => 'Password has been updated successfully',
                'created_by' => $user->id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
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
            $notification = [
                'title' => 'Payment Method Added',  
                'message' => 'New Payment Method has been Added successfully',
                'created_by' => $user->id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Added New Payment Method successfully', 'user' => $user, 'Payment Method' => $paymentMethod], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

    public function DeletePaymentMethod($id){
        $paymentMethod = PaymentMethod::find($id);
        if($paymentMethod){
            $paymentMethod->delete();
            $notification = [
                'title' => 'Payment Method Deleted',  
                'message' => 'Payment Method has been deleted successfully',
                'created_by' => $paymentMethod->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
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
            $notification = [
                'title' => 'Payment Method Updated',  
                'message' => 'Payment Method has been updated successfully',
                'created_by' => $paymentMethod->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
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
                $notification = [
                    'title' => 'Social Profile Updated',  
                    'message' => 'Social Profile has been updated successfully',
                    'created_by' => $social->user_id,
                    'status' => 0,
                    'clear' => 'no',
                ];
                Notification::create($notification);
                $social->update($data);
                return response()->json(['message' => 'Social Added successfully', 'user' => $user, 'Social' => $social], 200);
            } else {
                $social = SocialProfile::create($data);
                $notification = [
                    'title' => 'Social Profile Created',  
                    'message' => 'Social Profile has been created successfully',
                    'created_by' => $social->user_id,
                    'status' => 0,
                    'clear' => 'no',
                ];
                Notification::create($notification);
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
        $notification = [
            'title' => 'Delete Social Link',  
            'message' => 'Social link has been deleted successfully',
            'created_by' => $social->user_id,
            'status' => 0,
            'clear' => 'no',
        ];
        Notification::create($notification);
        return response()->json(['social' => $social], 200);


    }

    public function DealProvider($user_id){
        $user = User::find($user_id);
        $deals = Deal::where('user_id',$user_id)->get();
        $business = BusinessProfile::where('user_id',$user_id)->first();
        return response()->json(['message' => 'Social Added successfully', 'user' => $user, 'deals' => $deals, 'business' => $business], 200);
    }

    public function DetailUser($id){

        $user=User::find($id);

        $PaymentMethod=PaymentMethod::where('user_id',$id)->get();

        if($user){

            return response()->json(['user' => $user, 'PaymentMethod' => $PaymentMethod], 200);

        }
    }

    public function AddOrder(Request $request)
    {
        $user = User::find($request->customer_id);
        if ($user) {
            $data = $request->all();
            $order = Order::create($data);
            $notification = [
                'title' => 'Added New Order',  
                'message' => 'New Order has been added successfully',
                'created_by' => $user->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Added Order successfully', 'user' => $user, 'order' => $order], 200);
        } else {
            return response()->json(['message' => 'No user found'], 200);
        }
    }

    public function UpdateOrder(Request $request)
    {
        $order = Order::find($request->id);
        if ($order) {
            $data = $request->all();
            $order->update($data);
            $notification = [
                'title' => 'Added New Order',  
                'message' => 'New Order has been added successfully',
                'created_by' => $order->customer_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Updated Order successfully', 'order' => $order], 200);
        } else {
            return response()->json(['message' => 'No order found'], 200);
        }
    }

    public function Orders(Request $request)
    {
        $userId = Auth::id();
        $orders = Order::where('customer_id', $userId)->orderBy('id', 'desc')->get();
        if ($orders) {
            return response()->json(['message' => 'Orders List', 'orders' => $orders], 200);
        } else {
            return response()->json(['message' => 'No order available'], 200);
        }
    }

    public function Order($id)
    {
        $order = Order::find($id);
        if ($order) {
            return response()->json(['message' => 'Order Detail', 'order' => $order], 200);
        } else {
            return response()->json(['message' => 'No order available'], 200);
        }
    }

    public function UploadReview(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $data = $request->all();
            $review = Review::create($data);
            $notification = [
                'title' => 'Added Review',  
                'message' => 'A new review has been added successfully',
                'created_by' => $review->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Added Review successfully', 'user' => $user, 'review' => $review], 200);
        } else {
            return response()->json(['message' => 'No user login'], 200);
        }
    }

    public function UpdateReview(Request $request)
    {
        $review = Review::find($request->id);
        if ($review) {
            $data = $request->all();
            $review->update($data);
            $notification = [
                'title' => 'Review Update',  
                'message' => 'Review has been updated successfully',
                'created_by' => $review->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Review updated successfully', 'review' => $review], 200);
        } else {
            return response()->json(['message' => 'No review found'], 200);
        }
    }

    public function DeleteReview($id)
    {
        $review = Review::find($id);    
        if ($review) {
            $review->delete();
            $notification = [
                'title' => 'Review Delete',  
                'message' => 'Review has been deleted successfully',
                'created_by' => $review->user_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Review delete successfully','review' => $review], 200);
        } else {
            return response()->json(['message' => 'No review found'], 200);
        }
    }

    public function FilterService(Request $request)
    {
        $services = Deal::where('service_category', $request->service)->get();    
        if ($services) {
            return response()->json(['message' => 'Services List','services' => $services], 200);
        } else {
            return response()->json(['message' => 'No service available'], 200);
        }
    }

    public function AskForRevison(Request $request){

        $order = Order::find($request->order_id);
        if ($order) {
            $data = $request->all();
            if ($request->hasFile('images')) {
                foreach($request->file('images') as $image){
                    $photo1 = $image;
                    $photo_name1 = time() . '-' . $photo1->getClientOriginalName();
                    $photo_destination = public_path('uploads');
                    $photo1->move($photo_destination, $photo_name1);
                    $images[] = $photo_name1;
                }
            }
        
            $data['images'] =  json_encode($images);
            $data['type'] =  'revision';
            $afterImages = DeliveryImage::create($data);
            $notification = [
                'title' => 'Revision Request',  
                'message' => 'Revision request has been added successfully',
                'created_by' => $order->customer_id,
                'status' => 0,
                'clear' => 'no',
            ];
            Notification::create($notification);
            return response()->json(['message' => 'Added revision successfully', 'afterImages' => $afterImages], 200);
        } else {
            return response()->json(['message' => 'No order found'], 200);
        }
    }
}
