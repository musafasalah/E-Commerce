<!DOCTYPE html>
<html lang="en">
  <head>

   @include('admin.css')

   <style>
   .title_deg{
    text-align: center;
    font-size: 25px;
    font-weight: bold;
    padding-bottom: 40px;
   }
   .table_deg{
    border: 2px solid white;
    width: 100%;
    margin: auto;
    text-align: center;
   }
   .th_deg{
    background: skyblue;

   }
   .img_size{
    width: 200px;
    height: 100px;
   }

</style>

  </head>
  <body>
    <div class="container-scroller">
      <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
            <div class="ps-lg-1">
              <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                <a href="https://www.bootstrapdash.com/product/corona-free/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
      @include('admin.header')
        <!-- partial -->

        <div class="main-panel">

            <div class="content-wrapper">

                <h1 class="title_deg">All orders</h1>

                <div style="text-align: center; padding-bottom:30px;">

                    <form action="{{url('search')}}" method="GET">
                        @csrf

                        <input type="text" name="search" placeholder="Search For Something" style="color: black">
                        <input type="submit" value="Search" class="btn btn-outline-primary">

                    </form>
                </div>

                <table class="table_deg">

                    <tr class="th_deg">

                        <th style="padding: 10px">Name</th>
                        <th style="padding: 10px">Email</th>
                        <th style="padding: 10px">Address</th>
                        <th style="padding: 10px">Phone</th>
                        <th style="padding: 10px">Product Title</th>
                        <th style="padding: 10px">Quantity</th>
                        <th style="padding: 10px">Price</th>
                        <th style="padding: 10px">Payment Status</th>
                        <th style="padding: 10px">Delivery Status</th>
                        <th style="padding: 10px">image</th>
                        <th style="padding: 10px">Delivered</th>
                        <th style="padding: 10px">Print PDF</th>
                        <th style="padding: 10px">Send Email</th>
                    </tr>

                    @forelse ($order as $order )


                    <tr>
                        <td>{{$order->name}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->phone}}</td>
                        <td>{{$order->product_title}}</td>
                        <td>{{$order->quantity}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->payment_status}}</td>
                        <td>{{$order->delivery_status}}</td>
                        <td>
                            <img class="img_size" src="{{asset("storage/$order->image")}}" alt="" >
                        </td>

                        <td>
                            @if ($order->delivery_status == 'processing')

                            <a href="{{url('delivered',$order->id)}}" class="btn btn-primary" onclick="return confirm('Are you sure this product is delivered !!!')">Delivered</a>

                            @else

                            <p style="color: green;">Deliverd</p>

                            @endif

                        </td>

                        <td>

                            <a href="{{url('print_pdf',$order->id)}}}" class="btn btn-secondary">Print PDF</a>
                        </td>

                        <td>
                            <a href="{{url('send_email',$order->id)}}" class="btn btn-info">Send Email</a>
                        </td>
                    </tr>

                    @empty

                    <tr>

                        <td colspan="16">
                            NO DATA FOUND!!
                        </td>
                    </tr>

                    @endforelse
                </table>

            </div>

        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->

    @include('admin.script')
</body>
</html>
