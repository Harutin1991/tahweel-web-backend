<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Subscriber;
use App\Jobs\Subscribe;
use App\Admin\Product;
use App\Admin\MailContent;
use App\Admin\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestController extends Controller
{

    public function addSubscriber(Request $request)
    {
        $errorMessage = "";
        $success = true;
        $subscriber = [];
        try {
            $request->validate([
                "email" => "email"
            ]);

            $data = $request->all();
            $subscriber = Subscriber::create($data);
            if($subscriber) {
                $subscribers = Subscriber::where('status',0)->pluck('email');
                $mailData = MailContent::where('type','subsciber')->first();
                $mail = array('subject' => $mailData->subject, 'message' => $mailData->message);
                Subscribe::dispatch($subscribers, $mail);
                Subscriber::where('status', '=', 0)
                    ->update(['status' => 1]);
            }
        } catch (\Throwable $e){
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['subscriber'=>$subscriber,'success'=>$success,'errorMessage'=>$errorMessage]);
    }

    public function addJobApplicaion(Request $request)
    {
        $errorMessage = "";
        $success = true;
        $application = [];
        try {
            $request->validate([
                "name" => "required|max:191",
                "email" => "email",
                "job_title" => "max:191",
                "company" => "max:191",
                "phone" => "required|max:191",
                "subject" => "required|max:191",
                "message" => "required",
            ]);

            $data = $request->all();
            $application = JobApplication::create($data);
        } catch (\Throwable $e){
            $errorMessage = $e->getMessage();
            $success = false;
        }

        return response()->json(['application'=>$application,'success'=>$success,'errorMessage'=>$errorMessage]);
    }

    public function getAllProducts()
    {
        $errorMessage = "";
        $success = true;
        $productsResponse = [];
        try {
            $products = Product::with('category')->get();
            foreach($products as $product) {
                $productsResponse[$product->category->name]['products'][] = $product;
                $productsResponse[$product->category->name]['category'] = $product->category;
            }
        } catch (\Throwable $e){
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['category'=>$productsResponse,'success'=>$success,'errorMessage'=>$errorMessage]);
    }
}