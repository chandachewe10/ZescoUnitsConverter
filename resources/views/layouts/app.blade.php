<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

{{--    //add Jquery--}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">UnitsConverter |
                    <img src="images/logos/zesco.png" class="rounded-circle" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <!-- Footer -->
        <footer class="page-footer font-small bg-transparent">

            <!-- Copyright -->
            <div class="footer-copyright text-center py-3 fixed-bottom">© 2020 Copyright:
                <a href="https://danielngandu.com/"> Daniel Ng`andu & Jethro Mwanza</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
    </div>
    <script>
        $(document).ready(function() {

            //populate clients details
            $("#amount").on('keyup',function () {
                var amount = $("#amount").val();
                var vat = 0.00;
                var excise = 0.00;
                var totalTax =0.00;
                var amountAfterTax =0.00;
                var units =0.00;
                //calculate tax here
                vat = amount * 0.16;
                excise = amount * 0.03;
                totalTax = vat + excise;
                amountAfterTax = amount - totalTax;
                //populate fields
                $('#vat').val(vat);
                $('#excise').val(excise);
                $('#totalTax').val(totalTax);
                $('#amountAfterTax').val(amountAfterTax);



                //check bands
                /*
                * BANDS
                * ---------
                * R1
                * 100units -> K47
                * 200units -> k170
                * 300units -> k217 and above
                * */

                var R1units = 0.00;
                var R2units = 0.00;
                var R3units = 0.00;

                //if units < k47, do this
                if (amountAfterTax < 47){
                    units = amount/0.47;
                }else

                if(amountAfterTax >= 48 && amountAfterTax <= 217){
                    units = ((amount - 55.93)/(1.2 * 0.85));
                }else{
                    R1units = 100;

                    R2units = (170 / 0.85);

                    R3units = ((amount - 259)/(1.2 * 1.94));

                    units = R1units + R2units + R3units;
                }



                //populate field with units
                $('#units').val(units);


            });
        });



    </script>

</body>
</html>
