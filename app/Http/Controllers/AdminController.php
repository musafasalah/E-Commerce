<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\Product;
// use Barryvdh\DomPDF\PDF;
use App\Models\Category;
// use Illuminate\Notifications\Notification;
// use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use app\Notifications\SendEmailNotification;
use App\Notifications\PaymentReceived;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Facades\Notification;


class AdminController extends Controller
{
    public function view_category(){

        if(Auth::id()){

                    if(Auth::user()->usertybe == 1){

                        $data = Category::all();

                        return view('admin.category',compact('data'));
                    }
                    else{
                        return redirect()->back();
                    }
        }
        else
        {
            return redirect('login');
        }

    }

    public function add_category(Request $request){

       $data =  new Category;

       $data->category_name = $request->category;

       $data->save();

       return redirect()->back()->with('message','category added successfuly');

    }

    public function delete_category($id){

       $data = Category::findOrfail($id);

       $data->delete();

       return redirect()->back()->with('message','category deleted successfuly');

    }

    public function view_product(){

        if(Auth::id()){


                    if(Auth::user()->usertybe == 1){

                        $category = Category::all();

                        return view('admin.product',compact('category'));

                    }
                    else
                    {
                        return redirect()->back();
                    }

        }
        else{
            return redirect('login');
        }

    }

    public function add_product(Request $request){

        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount_price = $request->dis_price;

       $image = $request->image;

       $product->image = Storage::putFile('product',$image);

       //    $imagename=time().'.'.$image()->getClientOriginalExtension();

    //    $request->image->move_uploaded_file('product',$imagename);

    //    $product->image=$imagename;

    $product->save();

    return redirect()->back()->with('message','product added succssfuly');

}

public function show_product(){

    if(Auth::id()){
                if(Auth::user()->usertybe == 1){

                    $product = Product::all();

                    return view('admin.show_product',compact('product'));

                }else{

                    return redirect()->back();

                }
    }
    else{
        return redirect('login');
        }

    }

    public function delete_product($id){

       $product = Product::find($id);

       $product->delete();

       return redirect()->back()->with('message','Product deleted successfuly');
    }

    public function update_product($id){

        $product = Product::find($id);

        $category = Category::all();

        return view('admin.update_product',compact('product','category'));
    }

    public function update_product_confirm(Request $request , $id){

       $product = Product::find($id);

       $product->title = $request->title;
       $product->description = $request->description;
       $product->category = $request->category;
       $product->quantity = $request->quantity;
       $product->price = $request->price;
       $product->discount_price = $request->dis_price;


       $image = $request->image;
        if($image){

            $product->image = Storage::putFile('product',$image);
        }

       $product->save();

       return redirect()->back()->with('message','Product Updated successfuly');

    }

    public function order(){
        if(Auth::id()){

                    if(Auth::user()->usertybe == 1){

                        $order = Order::all();

                        return view('admin.order',compact('order'));

                    }
                    else{
                        return redirect()->back();
                    }

        }
        else
        {
            return redirect('login');
        }

    }

    public function delivered($id){

       $order = Order::find($id);

       $order->delivery_status = "Deliverd";
       $order->payment_status = "Paid";

       $order->save();

       return redirect()->back();

    }


    public function print_pdf($id){

       $order =  order::find($id);

       $pdf = PDF::loadView('admin.pdf',compact('order'));

       return $pdf->download('order_details.pdf');
    }

    public function send_email($id){

       $order = Order::find($id);

        return view('admin.send_info',compact('order'));
    }

    public function send_user_email(Request $request , $id){

       $order = Order::find($id);

       $details = [

        'greeting' => $request->greeting ,
        'firstline' => $request->firstline ,
        'body' => $request->body ,
        'button' => $request->button ,
        'url' => $request->url ,
        'lastline' => $request->lastline ,
       ];

       Notification::send($order,new SendEmailNotification($details));

       return redirect()->back();

    }

    public function searchdata(Request $request){

       $searchtext = $request->search;

       $order = Order::where('name','LIKE',$searchtext)->orwhere('phone','LIKE',$searchtext)->orwhere('product_title','LIKE',$searchtext)->get();

       return view('admin.order',compact('order'));

    }





}
