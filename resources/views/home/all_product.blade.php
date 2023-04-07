<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('home/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('home/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('home/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('home/css/responsive.css')}}" rel="stylesheet" />
   </head>
   <body>
      <div class="hero_area">
        
@include('sweetalert::alert')

         <!-- header section strats -->
@include('home.header')
         <!-- end header section -->


      <!-- product section -->
@include('home.product_view')
      <!-- end product section -->

      {{-- Comment and reply system start here --}}

      {{-- <div style="text-align: center ; padding-bottom : 30px;">

        <h1 style="font-size:30px; text-align:center; padding-top:20px; padding-bottom: 20px;">Comments</h1>

        <form action="" method="">

            <textarea name="" placeholder="Comment Something Here" style="height:150px ; width:600px;" ></textarea>

            <br>

            <a href="{{}}" class="btn btn-primary">Comment</a>

        </form>

      </div>

      <div style="padding-left: 20%;">

        <h1 style="font-size: 20px; padding-bottom:20px;">All Comment</h1>

        <div>
            <b>yousef</b>
            <p>this is first comment</p>

            <a href="javascript::void(0)">Reply</a>

        </div>

        <div>
            <b>salah</b>
            <p>this is 2nd comment</p>

            <a href="javascript::void(0)">Reply</a>

        </div>

        <div>
            <b>mustafa</b>
            <p>this is 3rd comment</p>

            <a href="javascript::void(0)">Reply</a>

        </div>
      </div> --}}


      {{-- Comment and reply system end here --}}

      <!-- subscribe section -->
{{-- @include('home.subscribe')
      <!-- end subscribe section -->
      <!-- client section -->
@include('home.client')
      <!-- end client section -->
      <!-- footer start -->
@include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
      </div> --}}

      <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            var scrollpos = sessionStorage.getItem('scrollpos');
            if (scrollpos) {
                window.scrollTo(0, scrollpos);
                sessionStorage.removeItem('scrollpos');
            }
        });

        window.addEventListener("beforeunload", function (e) {
            sessionStorage.setItem('scrollpos', window.scrollY);
        });
    </script>

      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
