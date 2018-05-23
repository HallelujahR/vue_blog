<nav id="nav" class="navbar navbar-default" role="navigation">
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
			        <ul class="nav navbar-nav">
			            <li><a class='fontColor' href="/article">文章</a></li>
			            <li><a class='fontColor' href="#">问题</a></li>
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
					<ul class="nav navbar-nav navbar-right"> 
			            <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> 注册</a></li> 
			            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>  -->

                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-plus"></span>
                                <!-- <b class="caret"></b> -->
                            </a>
                            <ul class="dropdown-menu" id="personLink" >
                                <li v-for="item in items">
                                    <a :href="item.link">{{item.message}}</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="" style="height:50px;width:50px;padding:0px;"><img src="<?php echo e(asset('image/testhead.jpg')); ?>" class="img-circle" style="height:45px;width:45px;margin-top:2px;"></a></li>
                    </ul> 
			    </div>
			</div>
    </div>
</nav>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
var example1 = new Vue({
  el: '#personLink',
  data: {
    items: [
      { message: '发布',link:'/' },
      { message: '设置',link:'/' },
      { message: '登出',link:'/' }
    ]
  }
})
    </script>
<?php $__env->stopSection(); ?>
