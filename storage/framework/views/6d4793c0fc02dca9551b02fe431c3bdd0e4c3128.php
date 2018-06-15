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
        <link rel="stylesheet" href="<?php echo e(asset('css/release.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/article.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/articleDetail.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
        <title>文章</title>
        <!-- Styles -->

    </head>
    <body>
        <div id="app">
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none">
                <?php echo e(csrf_field()); ?>

                <input type="submit" name="" id="logout" value="退出">
            </form>

            <nav id="nav" class="navbar navbar-default" role="navigation" >
                <div class="container"> 
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target="#example-navbar-collapse">
                                <span class="sr-only">切换导航</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="row"  id="head">
                            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                                <ul class="nav navbar-nav" id="tem">
                                    <li>
                                        <a href="<?php echo e(url('/article')); ?>" style="height:50px;" />
                                            <img src="<?php echo e(asset('image/logo.jpg')); ?>" class="img-responsive" style="height:50px;margin-top:-14px;">
                                       </a>
                                    </li>
                                </ul>
                                <?php if(Auth::check()): ?>
                                    <ul class="nav navbar-nav navbar-right" id="personLink">
                                    
                                        <transition-group name="slide-fade">
                                            <li   v-if="show" class="personLi" key="1" >
                                                <a class="personA" id="rel" href="#" data-toggle="modal" data-target="#Release" >
                                                    <span class="glyphicon glyphicon-pencil" ></span>
                                                    我的
                                                </a>
                                            </li>
                                            <li  v-if="show" class="personLi" key="2" >
                                                <a class="personA" href="/">
                                                    <span class="glyphicon glyphicon-cog"></span>
                                                    设置
                                                </a>
                                            </li>
                                            <li  v-if="show" class="personLi" key="3" >
                                                <a class="personA" href="#" @click="out" id="out">
                                                    <span class="glyphicon glyphicon-off"></span>
                                                    登出
                                                </a>
                                            </li>
                                        </transition-group>
                                        <li id="person" @click="show = !show">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </li>
                                        <li>
                                            <a id="headA" href="/user?id=<?php echo e(Auth::id()); ?>">
                                                <img src="<?php echo e(asset('image/testhead.jpg')); ?>" id="headImg" userid="<?php echo e(Auth::id()); ?>" class="img-circle">
                                            </a>
                                        </li>
                                    </ul> 
                                <?php else: ?>
                                    <ul class="nav navbar-nav navbar-right" id="personLink" > 
                                        <li><a href="#" data-toggle="modal" data-target="#myModal"  id="qh" ><span class="glyphicon glyphicon-user"></span> 注册</a></li> 
                                        <li><a href="#" data-toggle="modal" data-target="#myModal2" id="dl"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li> 
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                </div>
            </nav>
            <?php echo $__env->make('Nav.Signup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('Nav.Login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>            
            <div id="addetail">
                <adetail></adetail>   
            </div>

        </div>
    </body>
<script type="text/javascript" src="<?php echo e(mix('js/app.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/Time.js')); ?>"></script>
<script type="text/javascript">
//遍历登录后显示的信息，同时用了vue的动画过渡效果
var  personLink = new Vue({
    el: '#nav',
    data: {
        show:false,
    },
    mounted:function(){
        $('#nav').css({
            'position':'fixed',
            'top':'0px',
            'width':'100%',
            'margin-bottom':'120px',
            'z-index':'100',
        })
    },
    methods:{
        //登出操作
        out:function(){
            $('#logout').trigger('click');
        },

    }
});


new Vue({
    el:'#Release',
    data:{
        show:true,
    },
    methods:{
        test:function(){
            this.show = true;
        },
        test1:function(){
            this.show = false;
        }
    },
});


new Vue({
    el:'#addetail',
})

</script>
<?php echo $__env->yieldContent('js'); ?>
</html>
