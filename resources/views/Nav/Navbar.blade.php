<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
    {{ csrf_field() }}
    <input type="submit" name="" id="logout" value="退出">
</form>

<nav id="nav" class="navbar navbar-default" role="navigation" v-bind:style="styles">
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
                        <li><a class='fontColor' href="/article">文章</a></li>
                        <li><a class='fontColor' href="/question">问题</a></li>
                        <li><a class='fontColor' href="#">话题</a></li>
                        <li>
                            <form class="form-inline navbar-left" style="line-height:48px;">
                                    
                                    <div class="input-group">  
                                        <input type="text" class="form-control" placeholder="Amount"/>
                                        <div id="submit" class="input-group-addon">
                                            <div id="searchBtn" onClick={this.MouseClick}>
                                                寻找
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </li>
                    </ul>
                    @if(Auth::check())
                        <ul class="nav navbar-nav navbar-right" id="personLink">
                        
                            <transition-group name="slide-fade">
                                <li   v-if="show" class="personLi" key="1" >
                                    <a class="personA" id="rel" href="#" data-toggle="modal" data-target="#Release" >
                                        <span class="glyphicon glyphicon-pencil" ></span>
                                        发布
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
                                <a id="headA" href="">
                                    <img src="{{asset('image/testhead.jpg')}}" id="headImg" userid="{{Auth::id()}}" class="img-circle">
                                </a>
                            </li>
                        </ul> 
                    @else
                        <ul class="nav navbar-nav navbar-right" id="personLink" > 
                            <li><a href="#" data-toggle="modal" data-target="#myModal"  id="qh" ><span class="glyphicon glyphicon-user"></span> 注册</a></li> 
                            <li><a href="#" data-toggle="modal" data-target="#myModal2" id="dl"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li> 
                        </ul>
                    @endif
                </div>
            </div>
    </div>
</nav>

@include('Nav.Signup')
@include('Release.Release')
@include('Nav.Login')



