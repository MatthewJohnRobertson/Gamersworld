     <div class="container">
         <div class="row">
             <div class="col-12">
                 <nav class="main-nav">
                     <!-- ***** Logo Start ***** -->
                     <a href="{{ url('/') }}" class="logo">
                         <img class="mainLogo" src="{{ asset('assets/images/logo.png') }}" alt="GamersWorld Logo">
                     </a>
                     <!-- ***** Logo End ***** -->
                     <!-- ***** Menu Start ***** -->
                     <ul class="nav">
                         <li><a href="{{ url('/') }}" class="active">Home</a></li>
                         <li class="submenu">

                             <a href="{{url('/products') }}">Products</a>
                             <ul>
                                 <li><a href="{{url('/xbox-original') }}">Xbox</a></li>
                                 <li><a href="{{url('/ps2') }}">Play Station 2</a></li>
                         </li>
                     </ul>
                     <!-- <li><a href="single-product">Single Product</a></li> -->
                     <li><a href="{{url('/about')}}">About Us</a>
                     </li>
                     <li><a href="{{url('/contact')}}">Contact Us</a></li>
                     <li><a href="{{url('/customer/account')}}">Account</a></li>
                     <li><a href="{{url('/login')}}">Login</a></li>
                     <li><a href="{{url('/register')}}">Register</a></li>
                     </ul>
                     <!-- ***** Menu End ***** -->
                 </nav>
             </div>
         </div>
     </div>