<link rel="stylesheet" href="<?php echo e(asset('css/home.css')); ?>">
<header class="main-header">
	<nav id="nav" className="navbar navbar-default" role="navigation">
	    <div className="container"> 
			    <div className="navbar-header">
			        <button type="button" className="navbar-toggle" data-toggle="collapse"
			                data-target="#example-navbar-collapse">
			            <span className="sr-only">切换导航</span>
			            <span className="icon-bar"></span>
			            <span className="icon-bar"></span>
			            <span className="icon-bar"></span>
			        </button>
			    </div>
		    	<div className="row"  id="head">
				    <div className="collapse navbar-collapse" id="example-navbar-collapse">
				        <ul className="nav navbar-nav">
				            <li><a className='fontColor' href="#" onMouseEnter={this.MouseEnter} onMouseOut={this.MouseOut}>文章</a></li>
				            <li><a className='fontColor' href="#">图片</a></li>
				            <li><a className='fontColor' href="#">文章分类</a></li>
							<li>
								<form className="form-inline navbar-form navbar-left">
									    <label className="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
									    <div className="input-group">  
										    <input type="text" className="form-control" placeholder="Amount"/>
											<div id="submit" className="input-group-addon">
												<div id="searchBtn" onClick={this.MouseClick}>
													寻找
												</div>
										    </div>
									    </div>
								</form>
							</li>
				        </ul>
						<ul className="nav navbar-nav navbar-right"> 
				            <li><a href="#"><span className="glyphicon glyphicon-user"></span> 注册</a></li> 
				            <li><a href="#"><span className="glyphicon glyphicon-log-in"></span> 登录</a></li> 
				        </ul> 
				    </div>
				</div>
	    </div>
	</nav>
</header>

