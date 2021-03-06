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
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">姓名</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <transition name="fade" mode="out-in">
                    <template v-if="loginType === 'email'" >
                         <div class="form-group{{ $errors->has('accountSign') ? ' has-error' : '' }}" key="email">
                            <label for="email" class="col-md-4 control-label">邮箱</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="accountSign" value="{{ old('accountSign') }}" required>

                                @if ($errors->has('accountSign'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('accountSign') }}</strong>
                                    </span>
                                @endif
                            </div>
                            

                        </div>
                    </template>
                    <template v-else>
                          <div class="form-group{{ $errors->has('accountSign') ? ' has-error' : '' }}" key="phone" key="phone">
                                <label for="email" class="col-md-4 control-label">手机号</label>

                                <div class="col-md-6">
                                    <input id="phone" type="number" class="form-control" name="accountSign" value="{{ old('accountSign') }}" required>

                                    @if ($errors->has('accountSign'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('accountSign') }}</strong>
                                        </span>
                                    @endif
                                    <div id="sendMessage" @click="code">@{{codemessage}}</div>
                                    <transition name="fade">
                                        <input v-if="sendCode" type="number" name="code" class="form-control" style="width:50%" placeholder="请输入验证码" required>
                                    </transition>

                                    

                                    <input type="hidden" name="codekey" :value="codekey" />
                                     @if ($errors->has('code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                            </div>
                    </template>
                </transition>
                    <input type="hidden" name="account_type" :value="accounttype" />
                    <div class="form-group{{ $errors->has('passwordSign') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">密码</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="passwordSign" required>

                            @if ($errors->has('passwordSign'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('passwordSign') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                        <div class="col-md-6">
                            <input id="passwordSign-confirm" type="password" class="form-control" name="passwordSign_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                            <button type="button" class="btn btn-default" @click="toggle">@{{signType}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@section('js')
<script type="text/javascript">


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
           codekey:'',//从缓存中取出验证码的凭据
           accounttype:'email',//哪个注册方式
           signType:'手机注册',
        },  
        methods:{  
            toggle:function(){  
                // alert(1);
                this.flag = !this.flag  
                if(this.flag==true){  
                    this.loginType = "email"  
                    this.accounttype='email'
                    this.signType='手机注册'
                }else if(this.flag==false){  
                    this.loginType = "phone"  
                    this.accounttype='phone'
                    this.signType='邮箱注册'
                } 
            },
            //显示验证码
            code:function(event){
                let that = this;
                const DATA_KEY = '';
                this.phone = $('#phone').val();
                if(this.phone){
                    this.sendCode=true
                }else{
                    this.sendCode=false
                    alert('请输入手机号');
                    return false;   
                }
                var el = event.currentTarget
                if (this.isSend) { 
                    axios.post('VerificationCodes', {
                          phone:this.phone
                    })
                    .then(function (response) {
                        that.isSend =false;
                        const TIME_COUNT = 60
                        that.count = TIME_COUNT;  
                        that.sendCode=true;  
                        that.timer = setInterval(() => {    
                            if (that.count > 0 && that.count <= TIME_COUNT) {  

                                that.count--;
                                that.codemessage=that.count+"秒后再次发送";     
                            } else {     
                                that.sendCode = false
                                clearInterval(that.timer);     
                                that.timer = null;     
                                that.codemessage="获取验证码"   
                                that.isSend = true  
                            }    
                        }, 1000)  

                        that.codekey=response.data['key']
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 

                }  
            }  
        }, 
    });     
</script>

@if( $errors->first('name'))
    <script type="text/javascript">
        $('#qh').trigger('click');
    </script>
@elseif($errors->has('accountSign'))
    <script type="text/javascript">
        $('#qh').trigger('click');
    </script>
@elseif($errors->has('passwordSign'))
    <script type="text/javascript">
        $('#qh').trigger('click');
    </script>
@elseif( $errors->has('account'))
    <script type="text/javascript">
        $('#dl').trigger('click');
    </script>
@elseif($errors->has('password'))
    <script type="text/javascript">
        $('#dl').trigger('click');
    </script>
@elseif($errors->has('code'))
    <script type="text/javascript">
        $('#qh').trigger('click');
    </script>
@endif
@endsection
