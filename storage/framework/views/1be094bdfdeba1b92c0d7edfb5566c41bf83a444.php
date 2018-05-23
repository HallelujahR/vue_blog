<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
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
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            *{margin:0;padding:0;list-style-type:none;}
            html, body {
              width: 100%;
              height: 100%;
              overflow: hidden;
            }

            body {
              background: #e0e6eb;
            }

            svg {
              width: 100%;
              height: 100%;
              z-index : -1;
            position : absolute;
            }
            svg g {
              mix-blend-mode: lighten;
            }
            svg polygon {
              stroke: none;
              fill: white;
            }
        </style>
    </head>
    <body>



        <svg id="demo" viewBox="0 0 1600 600" preserveAspectRatio="xMidYMid slice">
          <defs>
            <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
              <stop id="stop1a" offset="0%" stop-color="#12a3b4"></stop>
              <stop id="stop1b" offset="100%" stop-color="#ff509e"></stop>
                      <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>">Login</a>
                        <a href="<?php echo e(route('register')); ?>">Register</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md">
                    Rivered
                </div>

                <div class="links">
                    <a href="/article">文章</a>
                    <a href="/question">问题</a>
                    <a href="/topic">话题</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
            </linearGradient>
            <linearGradient id="grad2" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
              <stop id="stop2a" offset="0%" stop-color="#e3bc13"></stop>
              <stop id="stop2b" offset="100%" stop-color="#00a78f"></stop>
            </linearGradient>
          </defs>
          <rect id="rect1" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad1)"></rect>
          <rect id="rect2" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad2)"></rect>
        </svg>
       
    </body>

<script type="text/javascript" src="<?php echo e(mix('js/app.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/TweenMax.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/Stats.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/Background_init.js')); ?>"></script>
<script>

</script>
</html>
