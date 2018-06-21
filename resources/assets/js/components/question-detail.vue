<template>
	<div id="q_main">
		<div id="ad_load" v-if="isLoad" >
    		<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    	</div>
    	<div v-else>
    		<div class="col-md-offset-2 col-md-8"  id="q_head">
    			
    			<div class="col-md-8">
    				<div id="q_t">
	    				<span v-for="topic in question.topic">
	    					<a href="" class="q_topic">{{topic.topic}}</a>
	    				</span>	
	    			</div>

	                <div>
	                	<span id="q_title">{{question.title}}</span>
	                </div>
	                <div style="position:relative">
		                <div id="q_desc" v-html="question.desc">
		                	
		                </div>
		                <div class="a_article_detail" v-if="!zk"></div>
	                </div>
	             	<div class="cold-md-4" id="q_head_action">

	             		<button @click="answer" type="button" class="btn btn-success"><i class="fa fa-pencil-square-o" style="margin-right:3px;" aria-hidden="true"></i>写回答</button>

	             		<button type="button" v-if="follow_bt" class="btn btn-info" @click="q_collection($event,question.id)">关注</button>

	             		<button type="button" v-else class="btn btn-primary" @click="q_collection($event,question.id)">已关注</button>
	             		<span id="q_comment" data-toggle="modal" data-target="#question_comment">
	             			<i class="fa fa-comment-o" aria-hidden="true" style="margin-left:10px;"></i> 
	             			<span>评论(<span id="cot">{{question.comment_count}}</span>)</span>
	             		</span>

                		<span id="q_zk" @click="q_zk($event)">∨点击展开</span>
                	</div>
                </div>

                <div class="col-md-4" id="q_head_right" >
                	<div class="q_head_right_son">
                		<div class="q_left" >
                			<div style="width:50%;float:right;text-align:center">
	                			<div>关注数 </div>
	                			<div>{{follow_count}}</div>
                			</div>
                		</div>

                		<div class="q_right">
                			<div style="width:50%;text-align:center">
	                			<div>回答数 </div>
	                			<div>{{question.answer_count}}</div>
                			</div>
                		</div>                		
                	</div>
                </div>
            </div>
            <transition name="slide-fade">
	            <div v-show="is_answer" class="col-md-offset-2 col-md-8" id="answer_edit" style="float:left;">
	            	<div id="answer">
	            		<div id="answerOne"></div>
	            	</div>
	           		<div id="answerTwo">
	           		
	           		</div>
	            	<div>
	            		<button type="button" @click="submit_answer($event,question.id)" class="btn btn-success">提交</button>
	            		<button type="button" @click="answer" class="btn btn-default">取消</button>
	            	</div>
	            </div>
	        </transition>

	        <!-- 遍历答案 -->
	        <div class="col-md-offset-2 col-md-8" id="q_answer">
	        	<div class="col-md-8" id="q_answer_body">
		        	<question-answer
		        	:qid="qid"
		        	></question-answer>
	        	</div>

	        	<div class="col-md-4" style="border:1px solid black">
	        		asdf
	        	</div>
	        </div>
    	</div>
    	<question-comment
    	:qid="qid"
    	></question-comment>
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return {
				qid:'',
				isLoad:true,
				question:[],
				zk:false,
				follow_bt:true,
				follow_count:'',
				editor:'',
				is_answer:false,
				is_pic:false,
			}
		},
		beforeMount(){
			this.init();
		},
		updated(){
    		$('#q_desc').find('img').addClass('img-responsive');

    		if(!this.is_pic){
    			$('#q_desc').find('img').css({'display':'none'});
    		}
    		// console.log(document.getElementById('headImage'));
    	},
		methods:{
			init:function(){
				let self = this;
				this.qid = this.GetQueryString('id=');
				axios.post('/question/getDetail', {
				 	id:this.qid,
				})
				.then(function (response) {
					self.isLoad=false;
					self.question = response.data;
					self.follow_count = response.data['follow_count'];
					if(response.data['is_collection'] == '0'){
						self.follow_bt = true;
					}else{
						self.follow_bt = false;
					}
				  	// console.log(response);
				})
				  .catch(function (error) {
				    console.log(error);
				});


					
			},
			//利用正则获取url地址的传递参数
        	GetQueryString:function(name) {
            	var reg = new RegExp("(^|&)"+ name +"([^&]*)(&|$)");
            	var r = window.location.search.substr(1).match(reg);
            	if(r!=null)return  unescape(r[2]); return null;
        	},
        	q_zk:function(event){
        		if(!this.zk){
	        		$('#q_desc').css({
	        			'height':'auto',
	        		});
	        		$('#q_desc').find('img').css({'display':'block'});
	        		this.zk=true;
	        		this.is_pic=true;
	        		event.target.innerHTML = '∧点击收起';
        		}else{
        			$('#q_desc').css({
	        			'height':'100px',
	        		});
	        		$('#q_desc').find('img').css({'display':'none'});
	        		this.zk=false;
	        		this.is_pic=false;
	        		event.target.innerHTML = '∨点击展开';
        		}
        	},
        	q_collection:function(event,qid){
        		let self = this;
        		axios.get('/question/follow?id='+qid)
        		.then((response) =>{
        			switch(response['data']){
			    	case 2:
				    	new Swal({ 
						  title: "请先登录", 
						  timer: 1200, 
						  showConfirmButton: false 
						});
			    	break;
			    	case 0:
			    		new Swal({ 
						  title: "取消关注", 
						  timer: 800, 
						  showConfirmButton: false 
						});
						self.follow_count--;
						self.follow_bt = true;
			    	break;
			    	case 1:
			    		new Swal({ 
						  title: "已关注", 
						  timer: 800, 
						  showConfirmButton: false 
						});
						self.follow_count++;
						self.follow_bt = false;
			    	break;
			    }
        		})
        		.catch((error) =>{
        			console.log(error);
        		});
        	},
        	answer:function(){
        		if(!$('#headImg').attr('userid')){
        			new Swal({ 
					  title: "请登录", 
					  timer: 800, 
					  showConfirmButton: false 
					});
					return false;
        		}
        		this.is_answer = !this.is_answer;
        		this.editor = new E('#answerOne','#answerTwo');
				//配置菜单
				this.editor.customConfig.menus = [
			 	'head',  // 标题
			    'bold',  // 粗体
			    'fontSize',  // 字号
			    'fontName',  // 字体
			    'italic',  // 斜体
			    'underline',  // 下划线
			    'strikeThrough',  // 删除线
			    'link',  // 插入链接
			    'image',  // 插入图片
			    
			    'quote',  // 引用
			    'justify',  // 对齐方式
			    'list',  // 列表
			    'code',  // 插入代码
			    'undo',  // 撤销
			    'redo'  // 重复
			    ]
			    this.editor.customConfig.showLinkImg = false
			    this.editor.customConfig.uploadImgShowBase64 = true;
			    // this.editor.customConfig.uploadImgServer = '/upload'
				this.editor.create();
				this.editor.txt.html('<p>在此处输入文章内容</p>');
        	},
        	submit_answer:function(event,id){
        		axios.post('/answer/store',{
        			content:this.editor.txt.html(),
        			id:id,
        		})
        		.then((response) =>{
        			switch(response['data']){
				    	case 3:
				    		new Swal({ 
							  title: "请输入内容", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    	case 2:
				    		new Swal({ 
							  title: "请登录", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    	case 0:
				    		new Swal({ 
							  title: "发布失败", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    	case 1:
							new Swal({ 
							  title: "发布成功", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    	default:
							
				    }
        			// console.log(response);
        		})

        		// console.log(id);
        	}
		},
	}
</script>