<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/apphome.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <div class="dropdown">
                          <div class="dropbtn"></div>
                          <img src="/img/music.png" height="45px" width="45px"/>
                            <div class="dropdown-content">
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/5qap5aO4i9A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/sjkrrmBnpGE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <iframe width="475" height="315" src="https://www.youtube.com/embed/xFZSLUC5x-I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                  <iframe width="475" height="315" src="https://www.youtube.com/embed/XULUBg_ZcAU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                  <iframe width="475" height="315" src="https://www.youtube.com/embed/Dx5qFachd3A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                  <iframe width="475" height="315" src="https://www.youtube.com/embed/QEDZd066a2k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>



                                        </div>
                                      </div>


                                      <!-- the start of the to do drop down -->

<div class="dropdown">
<div class="dropbtn"></div>
<img src="/img/todo.png" height="45px" width="45px"/>
  <div class="dropdown-content">




    <h1> To do list</h1>
    <p>
      Coming Soon.
    </p>

      <!-- <div id="ppparent">

          <div id="pparent">

              <div id="myDIV" class="headertodo">


                    <h2 style="margin:5px">My To Do List</h2>
                    <input type="text" id="myInput" placeholder="Task To Do">
                    <span onclick="newElement()" class="addBtn">Add</span>
                    </div>

                                    <ul id="myUL">


        </div>
    </div> -->
  </div>
</div>

                                            <!-- the end of drop down to do list -->


<div class="dropdown">
<div class="dropbtn"></div>
<img src="/img/analize.png" height="45px" width="45px"/>
  <div class="dropdown-content">
      <h1> Analytics of Personal Performance</h1>
      <p>
        Coming Soon.
      </p>

              </div>
</div>

<!-- <div class="dropdown">
<div class="dropbtn"></div>
<img src="/img/takeabreak.png" height="45px" width="45px"/>
  <div class="dropdown-content">
      <h1> a break time or something</h1>

              </div>

</div> -->

<div class="dropdown">
<div class="dropbtn"></div>
<img src="/img/best.png" height="55px" width="55px"/>
  <div class="dropdown-content">
      <h1> Top 10 in the last 24 hrs</h1>
      <p>
        Coming Soon.
      </p>

              </div>

</div>
                                      </div>
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
    </div>

</body>

</html>
