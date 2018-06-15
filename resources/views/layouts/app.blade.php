<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/home.css')}}">
        <link rel="stylesheet" href="{{asset('css/release.css')}}">
        <link rel="stylesheet" href="{{asset('css/article.css')}}">
        <link rel="stylesheet" href="{{asset('font-awesome-4.7.0/css/font-awesome.min.css')}}">
        @yield('css')
        <title>Laravel</title>
        <!-- Styles -->
        <style>
           @media only screen and (max-width: 1024px){ 
                .main-header{
                    background:url({{asset('image/backgroundSmall2.jpg')}});
                    background-repeat:no-repeat;
                    height:220px;
                    margin-bottom:-5px;
                    background-size:cover;
                }
            }
            @media only screen and (min-width: 1024px){
                .main-header{
                    background-image: url({{asset('image/background2.jpg')}});
                    background-position:0px -350px;
                    background-size:cover;
                    background-repeat:no-repeat;
                    height:240px;
                }
            }

        </style>
    </head>
    <body>
        <header class="main-header">
        </header>
        <div id="app">
        @include('Nav.Navbar')
            <div class="main container " id="main"  v-bind:style="stylesImp" style="position:relative">
                <div class="col-md-8" id="mainImp" style="position:relative;padding:0px">
                    @yield('content')
                </div>
                <div class="col-md-4" v-bind:style="styleFix"  style="border:1px solid pink;height:20px;right:0px;">
                    
                </div>
                
            </div>
        </div>
    </body>
<script type="text/javascript" src="{{mix('js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('js/Time.js')}}"></script>
<script type="text/javascript">
//遍历登录后显示的信息，同时用了vue的动画过渡效果
var  personLink = new Vue({
    el: '#nav',
    data: {
        show:false,
        searchBarFixed:'',
        styles:{
            '':'',
        },
        stylesImp:{
            'border':'1px solid red',
        },
    },
    mounted () {
        window.addEventListener('scroll', this.handleScroll)
    },
    destroyed () {
      window.removeEventListener('scroll', this.handleScroll)
    },
    methods:{
        //登出操作
        out:function(){
            $('#logout').trigger('click');
        },
       handleScroll () {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
            var offsetTop = $('.main-header').height();
            if (scrollTop > offsetTop+20) {
                // this.searchBarFixed = true
                this.styles={
                    'position':'fixed',
                    'top':'0px',
                    'width':'100%',
                    'margin-bottom':'120px',
                    'z-index':'100',
                },
                this.stylesImp={
                    'margin-top':'120px',
                    'border':'1px solid black',
                }
            } else {
                // this.searchBarFixed = false
                this.styles='';
            }
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
    el:'#main',
        data: {
        styleFix:{
            '':''
        },
        stylesImp:{
            
            '':'',
        },

    },
    mounted () {
        window.addEventListener('scroll', this.handleScroll)
    },
    methods:{
      
       handleScroll () {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
            var offsetTop = $('.main-header').height();
            if (scrollTop > offsetTop) {
                // this.searchBarFixed = true

                this.stylesImp={
                    'margin-top':'130px',
                },
                this.styleFix={
                    '':'',
                }
            } else {
                this.stylesImp={
                    '':'',
                },
                this.styleFix={
                    '':'',
                }
            }
        },
    } 
})


</script>
@yield('js')
</html>
