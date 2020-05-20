<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            body{
              background-image: url('/img/sky.jpg');
              height: 100%;
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                centered: 100px;
                top: 475px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;

            }

            .links > a {
                color: white;
              font-family: 'Audiowide', cursive;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                background-image: -webkit-linear-gradient(20deg, #f35626, #feab3a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                -webkit-animation: hue 10s infinite linear;
            }

            .m-b-md {
                margin-bottom: 20px;
                color: white;

                background-image: -webkit-linear-gradient(20deg, #f35626, #feab3a);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                -webkit-animation: hue 10s infinite linear;
                /* font-family: 'Monoton', cursive; */
                font-family: 'Audiowide', cursive;
              }
              @-webkit-keyframes hue {
                from {
                  -webkit-filter: hue-rotate(0deg);
                }
                to {
                  -webkit-filter: hue-rotate(-360deg);
            }
          }

/* #welcomeSuccess{

  position: absolute;
  left: 699px;
  top: 180px;

} */


        </style>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Go to your Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- <div id="welcomeSuccess">
              <img src="/img/moon.svg" height="300px" width="300px"/>

            </div> -->
            <div class="content">
                <div class="title m-b-md">
                    AxisPro
                </div>
                <div>
                  <p>
                    Access Productivity
                  </p>
                </div>
            </div>
        </div>
    </body>
</html>
