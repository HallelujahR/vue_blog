<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">

        <title>Laravel</title>


        <!-- Styles -->
        <style>
           @media  only screen and (max-width: 1024px){ 
                .main-header{
                    background:url(<?php echo e(asset('image/backgroundSmall2.jpg')); ?>);
                    background-repeat:no-repeat;
                    height:220px;
                    margin-bottom:-5px;
                    background-size:cover;
                }
            }
            @media  only screen and (min-width: 1024px){
                .main-header{
                    background-image: url(<?php echo e(asset('image/background2.jpg')); ?>);
                    background-position:-50px -350px;
                    background-repeat:no-repeat;
                    height:240px;
                }
            }
        </style>
    </head>
    <body>
        <header class="main-header">
        </header>
        <?php echo $__env->make('Nav.Navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div id="app">
            <div class="main">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>

    </body>

<script type="text/javascript" src="<?php echo e(mix('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('js'); ?>
</html>
