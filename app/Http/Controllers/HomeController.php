<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;
use Session;
use RealRashid\SweetAlert\Facades\Alert;



class HomeController extends Controller
{

    public function index(){

       $product = Product::paginate(6);

        return view('home.userpage',compact('product'));
    }
    public function redirect(){

       $usertybe =  Auth::user()->usertybe;

       if($usertybe == '1'){

        $total_products = Product::all()->count();
        $total_orders = Order::all()->count();
        $total_users = User::all()->count();

        $order = Order::all();

        $total_revenue = 0;

        foreach($order as $order)
        {
            $total_revenue = $total_revenue + $order->price ;
        }

        $total_delivered = Order::where('delivery_status','=','Deliverd')->get()->count();

        // $total_processing = Order::where('delivery_status','=','processing')->get()->count();

           $total_processing = $total_orders - $total_delivered ;

        return view('admin.home',compact('total_products','total_orders','total_users','total_revenue','total_delivered','total_processing'));
       }

       else{

       $product = Product::paginate(6);

       return view('home.userpage',compact('product'));

       }

    }

    public function product_details($id){

       $product = Product::find($id);

        return view('home.product_details',compact('product'));
    }

    public function add_cart(Request $request ,$id){

        if(Auth::id())
        {
           $user = Auth::user();

           $user_id = $user->id;

           $product = Product::find($id);

           $product_exist_id = Cart::where('product_id','=',$id)->where('user_id','=',$user_id)->get('id')->first();

           if($product_exist_id){

            $cart = Cart::find($product_exist_id)->first();

            $quantity = $cart->quantity ;

            $cart->quantity = $quantity + $request->quantity ;

            if($product->discount_price)
            {

                $cart->price = $product->discount_price * $cart->quantity;

            }else{

                $cart->price = $product->price * $cart->quantity;
            }

            $cart->save();

            Alert::success('product Added succcessfuly','we have added product to the cart');

            return redirect()->back();

           }
           else{

            $cart = new Cart;

           $cart->name = $user->name ;
           $cart->phone = $user->phone ;
           $cart->email = $user->email ;
           $cart->address = $user->address;
           $cart->user_id = $user->id;

           $cart->product_title = $product->title;

           if($product->discount_price)
           {

               $cart->price = $product->discount_price * $request->quantity;

           }else{

               $cart->price = $product->price * $request->quantity;
           }
           $cart->image = $product->image;
           $cart->product_id = $product->id;

           $cart->quantity = $request->quantity;

           $cart->save();

           Alert::success('product Added succcessfuly','we have added product to the cart');

           return redirect()->back();

           }

        }
        else
        {
            return redirect('login');
        }
    }
    public function show_cart(){

        if(Auth::id())
        {
        $id = Auth::user()->id;
        $cart = Cart::where('user_id','=',$id)->get();

        return view('home.show_cart',compact('cart'));
        }
        else
        {
            return redirect('login');
        }

    }

    public function remove_cart($id){

       $cart = Cart::find($id);

       $cart->delete();

       return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::user();

        $userid = $user->id;

        $data = Cart::where('user_id','=',$userid)->get();

        foreach($data as $data)
        {
            $order = new Order;

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->quantity = $data->quantity;
            $order->price = $data->price;
            $order->image = $data->image;
            $order->product_id = $data->product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id  = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

        }

        Alert::success('We Have Received Your Order .','We will connect With you Soon...');


        return redirect()->back();

    }

    public function stripe($totalprice){

        return view('home.stripe',compact('totalprice'));
    }

    // public function stripePost(Request $request ,$totalprice)
    // {
    //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     stripe\charge::create([
    //             "amount" => $totalprice * 100,
    //             "currency" => "usd",
    //             "source" => $request->stripeToken,
    //             "description" => "Thanks For Payment"
    //     ]);

    //     $user = Auth::user();

    //     $userid = $user->id;

    //     $data = Cart::where('user_id','=',$userid)->get();

    //     foreach($data as $data)
    //     {
    //         $order = new Order;

    //         $order->name = $data->name;
    //         $order->email = $data->email;
    //         $order->phone = $data->phone;
    //         $order->address = $data->address;
    //         $order->user_id = $data->user_id;
    //         $order->product_title = $data->product_title;
    //         $order->quantity = $data->quantity;
    //         $order->price = $data->price;
    //         $order->image = $data->image;
    //         $order->product_id = $data->product_id;

    //         $order->payment_status = 'paid';
    //         $order->delivery_status = 'processing';

    //         $order->save();

    //         $cart_id  = $data->id;
    //         $cart = Cart::find($cart_id);
    //         $cart->delete();

    //     }

    //     // Session::flash('success', 'Payment successful!');

    //     return redirect()->back()->with('success' , 'Payment successful!');
    // }

    public function show_order(){

        if(Auth::id()){

            $user = Auth::user();

            $userid = $user->id ;

            $order = Order::where('user_id','=',$userid)->get();

            return view('home.show_order',compact('order'));
        }
        else{

            return redirect('login');
        }
    }

    public function cancel_order($id){

        $order = Order::find($id);

        // $order->delivery_status = 'Canceled';

        $order->delete();

        return redirect()->back();

    }

    public function product_search(Request $request){

        $search_text = $request->search;

        $product =  Product::where
        ('title','LIKE',$search_text)->orWhere('category','LIKE',$search_text)->orWhere('description','LIKE',$search_text)->paginate(6);

       return view('home.userpage',compact('product'));
    }

    public function products(){

       $product =  Product::paginate(6);


       return view('home.all_product',compact('product'));

       Alert::success('product Added succcessfuly','we have added product to the cart');

    }

    public function search_product(Request $request){

        $search_text = $request->search;

        $product =  Product::where
        ('title','LIKE',$search_text)->orWhere('category','LIKE',$search_text)->orWhere('description','LIKE',$search_text)->paginate(6);

       return view('home.all_product',compact('product'));
    }


}
