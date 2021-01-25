<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{\Portal\Models\Setting::where('key','title')->first()->value}}Portal</title>
    
    <!-- Fonts -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">--}}
    {{--<!-- Styles -->--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
     {{--<link href="{{ elixir('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{url('/css/bootstrap.css')}}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{url('/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{url('/css/custom.css')}}" rel="stylesheet" />
    <!-- JQUERY UI STYLES-->
    <link href="{{url('/css/jquery-ui.min.css')}}" rel="stylesheet" />
    <link href="{{url('/css/jquery-ui.theme.min.css')}}" rel="stylesheet" />
    <link href="{{url('/css/jquery-ui.structure.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/fakeloader.css') }}" rel="stylesheet">
    <!-- GOOGLE FONTS-->
    <style>
        body {
            font-family: 'Lato';

        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
@yield('head')
</head>
<body id="app-layout">
<div id="fakeloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div>

<div class="wrapper">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <div style="float: left; margin-left: -50px; margin-right: 20px;"><img src="{{url('/images/logo1.png')}}" height="50px" width="50px"
                                               class="img-rounded"></div>
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/admin') }}">

                   {{ \Portal\Models\Setting::where('key','title')->first()->value }} PORTAL
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    {{--<li><a href="{{ url('/home') }}">Home</a></li>--}}
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    
                    @if (Auth::guest())
                        {{--<li><a href="{{ url('/login') }}">Login</a></li>--}}
                        {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->getN() }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/user/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                               <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    @if(Auth::user()->is_staff)
                        <li>
                            <a href="{{url('/staff/students')}}"><i class="fa fa-users "></i>Students</a>
                        </li>
                        <li>
                            <a href="{{url('/result')}}"><i class="fa fa-clipboard "></i>Student Results </a>
                        </li>
                        <li>
                            <a href="{{url('/collate')}}"><i class="fa fa-circle-o-notch"></i>Collate Results</a>
                        </li>
                        <li>
                            <a href="{{url('/results/manageclass')}}"><i class="fa fa-circle-o-notch"></i>Manage Results</a>
                        </li>
                        <li>
                            <a href="{{url('/staff/pwdchange')}}"><i class="fa fa-key"></i>Change Password</a>
                        </li>
                    @else
                        <li>
                            <a href="{{url('/admin')}}" ><i class="fa fa-desktop "></i>Dashboard <span class="badge">main</span></a>
                        </li>
                        <li class="active-link">
                            <a href="{{url('/students/all')}}"><i class="fa fa-users "></i>Students  <span class="badge">all</span></a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/profiles')}}"><i class="fa fa-user "></i>Student Profiles</a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/graduate')}}"><i class="fa fa-graduation-cap "></i>Graduate Students</a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/promote')}}"><i class="fa fa-plus "></i>Promote Students</a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/graduates')}}"><i class="fa fa-graduation-cap "></i>Alumni </a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/inactive')}}"><i class="fa fa-ban "></i>Inactive Students</a>
                        </li>
                        <li>
                            <a href="{{url('/result')}}"><i class="fa fa-clipboard "></i>Results  <span class="badge">all</span></a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/results/upload')}}"><i class="fa fa-upload "></i>Upload Student Results </a>
                        </li>
                        <li class="col-md-offset-1">
                            <a href="{{url('/collate')}}"><i class="fa fa-circle-o-notch "></i>Collate Student Results </a>
                        </li>
                        <li>
                            <a href="{{url("/subjects")}}"><i class="fa fa-file-text "></i>Subjects</a>
                        </li>
                        <li>
                            <a href="{{url("/staff")}}"><i class="fa fa-users"></i>Staff</a>
                        </li>
                        <li>
                            <a href="{{url("/termsettings")}}"><i class="fa fa-gears"></i>Settings</a>
                        </li>
                    @endif
                </ul>
            </div>

        </nav>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">

                        <!-- /. ROW  -->
                        <hr />
        @include('layouts.alert')
        @yield('content')

                </div>
            </div>
        </div>
    </div>




    <!-- JavaScripts -->
    <script src="{{url('/js/jquery.js')}}"></script>
    <script src="{{url('/js/custom.js')}}"></script>
    {{--<!-- BOOTSTRAP SCRIPTS -->--}}
    <script src="{{url('/js/bootstrap.min.js')}}"></script>
    <script src="{{url('/js/angular.min.js')}}"></script>
    <script src="{{url('/js/jquery-ui.min.js')}}"></script>
    <script src="{{url('/js/jquery.form.js')}}"></script>
    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/fakeloader.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            window.FakeLoader.init( { auto_hide: true } );

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

        });

    </script>

    @yield('footer')
</div>
</body>
</html>
