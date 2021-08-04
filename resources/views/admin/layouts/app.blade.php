<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
        <title>i4Vision</title>
        <!-- Scripts -->
        <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/DataTables/bootstrap.css') }}">
        <link href="{{ asset('plugins/DataTables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
		
		<link href="{{ asset('plugins/spinner/ui.spinner.css') }}" rel="stylesheet">

        @stack('styles')
    </head>
    <body>

        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/admin/') }}">
                        <!-- {{ config('app.name', 'Laravel') }} -->
                        i4Vision
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        @auth

                            @if (Auth::user()->type == "admin" || Auth::user()->type == "user")
                                <ul class="navbar-nav mr-auto">

                                    <li class="nav-item @if (isset($page_name) && $page_name == 'users') active @endif">
                                        <a class="nav-link" href="{{ Route('admin.users') }}">{{ __('Users') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'devices') active @endif">
                                        <a class="nav-link" href="{{ Route('admin.devices') }}">{{ __('Devices') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'images') active @endif">
                                        <a class="nav-link" href="{{ Route('admin.images') }}">{{ __('Images') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'flows') active @endif">
                                        <a class="nav-link" href="{{ Route('admin.flows') }}">{{ __('Flows') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'galleries') active @endif">
                                        <a class="nav-link" href="{{ route('admin.galleries') }}">{{ __('Galleries') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'sites') active @endif">
                                        <a class="nav-link" href="{{ route('admin.sites') }}">{{ __('Sites') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'schedules') active @endif">
                                        <a class="nav-link" href="{{ route('admin.schedules') }}">{{ __('Schedules') }}</a>
                                    </li>
                                </ul>
                            @endif

                            @if (Auth::user()->type == "super_admin") 
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'clients') active @endif">
                                        <a class="nav-link" href="{{ route('admin.clients') }}">{{ __('Clients') }}</a>
                                    </li>
                                    <li class="nav-item @if (isset($page_name) && $page_name == 'devices') active @endif">
                                        <a class="nav-link" href="{{ route('admin.devices') }}">{{ __('Devices') }}</a>
                                    </li>
                                </ul>
                            @endif
                        @endauth
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('admin.register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->username }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            {{ __('Profile') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
			@auth
				<div class="container">
					<br>
					<h5>{{ Auth::user()->client->name }} ({{ Auth::user()->client->description }})</h5>
				</div>
			@endauth
            <main class="py-4">
                @yield('content')
            </main>
        </div>
		
		<div style="position: fixed;top: 0px;left: 0px;background: rgb(95 93 90 / 31%);color: rgb(255 0 0); display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; z-index: 9999; display: none;" class="spinner"></div>
    </body>
    <script type="text/javascript" src="{{ asset('plugins/backend/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/DataTables/jquery.dataTables.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('plugins/backend/bootstrap.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('plugins/DataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('plugins/bootbox/bootbox.all.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable();
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });

    </script>
    @stack('scripts')
</html>
