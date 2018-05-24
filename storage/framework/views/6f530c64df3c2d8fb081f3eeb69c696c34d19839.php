<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none">
    <?php echo e(csrf_field()); ?>

    <input type="submit" name="" id="logout" value="退出">
</form>

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
                    <?php if(Auth::check()): ?>
                        <ul class="nav navbar-nav navbar-right" id="personLink">
                        
                            <transition-group name="slide-fade">
                                <li  v-for="(item, index) in items"  v-if="show" class="personLi" :key="index" >
                                    <a class="personA" :href="item.link">
                                        <span :class="item.class"></span>
                                        {{item.message}}
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
                                    <img src="<?php echo e(asset('image/testhead.jpg')); ?>" id="headImg" class="img-circle">
                                </a>
                            </li>
                        </ul> 
                    <?php else: ?>
                        <ul class="nav navbar-nav navbar-right" id="personLink" > 
                            <li><a href="#" data-toggle="modal" data-target="#myModal"  id="qh" ><span class="glyphicon glyphicon-user"></span> 注册</a></li> 
                            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li> 
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">注册</h4>
      </div>
      <div class="modal-body">
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <label for="name" class="col-md-4 control-label">姓名</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus>

                            <?php if($errors->has('name')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <transition name="fade" mode="out-in">
                    <template v-if="loginType === 'email'" >
                         <div class="form-group<?php echo e($errors->has('account') ? ' has-error' : ''); ?>" key="email">
                            <label for="email" class="col-md-4 control-label">邮箱</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="account" value="<?php echo e(old('account')); ?>" required>

                                <?php if($errors->has('account')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('account')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="account_type" value="email" />

                        </div>
                    </template>
                    <template v-else>
                          <div class="form-group<?php echo e($errors->has('account') ? ' has-error' : ''); ?>" key="phone" key="phone">
                                <label for="email" class="col-md-4 control-label">手机号</label>

                                <div class="col-md-6">
                                    <input id="phone" type="number" class="form-control" name="account" value="<?php echo e(old('account')); ?>" required>

                                    <?php if($errors->has('account')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('account')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                    <div id="sendMessage" @click="code">{{codemessage}}</div>
                                    <transition name="fade">
                                        <input v-if="sendCode" type="number" class="form-control" style="width:50%" placeholder="请输入验证码" required>
                                    </transition>
                                </div>
                                <input type="hidden" name="account_type" value="phone" />
                            </div>
                    </template>
                </transition>

                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <label for="password" class="col-md-4 control-label">密码</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                            <button type="button" @click="toggle">切换</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    //遍历登录后显示的信息，同时用了vue的动画过渡效果
    var  personLink = new Vue({
      el: '#nav',
      data: {
        items: [
          {class:'glyphicon glyphicon-pencil',message: '发布',link:'/' },
          {class:'glyphicon glyphicon-cog',message: '设置',link:'/' },
        ],
        show:false,

      },
      methods:{
        //登出操作
        out:function(){
            $('#logout').trigger('click');
        },

      }
    })


    const myModal = new Vue({  
        el:"#myModal",  
        data:{  
           flag:true,//单位切换开关
           loginType:'email',
           sendCode:false,//验证码输入框开关
           isSend:true,//验证码是否发送过
           count:'',//验证码时间
           timer:null,//验证码定时器
           codemessage:'获取验证码',//验证码处显示的消息
           phone:'',//注册的电话号码
        },  
        methods:{  
            toggle:function(){  
                // alert(1);
                this.flag = !this.flag  
                if(this.flag==true){  
                    this.loginType = "email"  
                }else if(this.flag==false){  
                    this.loginType = "phone"  
                } 
            },
            //显示验证码
            code:function(event){
                this.sendCode=true
                this.phone = $('#phone').val();
                var el = event.currentTarget
                    // this.isSend = false
                if (this.isSend) { 
                    const TIME_COUNT = 60
                    this.count = TIME_COUNT;    
                    this.timer = setInterval(() => {    
                        if (this.count > 0 && this.count <= TIME_COUNT) {  

                            this.count--;
                            this.codemessage=this.count+"秒后再次发送";     
                        } else {     
                            this.sendCode = false
                            clearInterval(this.timer);     
                            this.timer = null;     
                            this.codemessage="获取验证码"   
                            this.isSend = true  
                        }    
                    }, 1000)  

                    axios.post('VerificationCodes', {
                          phone:this.phone
                      })
                      .then(function (response) {
                        console.log(response)
                      })
                      .catch(function (error) {
                        console.log(error);
                      }); 
                }  
            }  
        }, 
    })     
</script>






<?php if( $errors->first('name')): ?>
    <script type="text/javascript">
        $('#qh').trigger('submit').prevendDefault();
    </script>
@ifelse($errors->has('account'))
    <script type="text/javascript">
        $('#qh').trigger('submit').prevendDefault();
    </script>
@ifelse(errors->has('password'))
    <script type="text/javascript">
        $('#qh').trigger('submit').prevendDefault();
    </script>
<?php endif; ?>

<?php $__env->stopSection(); ?>


