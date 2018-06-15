<template>
	<div id="ad_comment">
		<div style="margin-bottom:15px;margin-left:0px;" class="row">
			<form class="form-inline" >
			  <div class="form-group" style="width:100%">
				<input type="text" id="ad_comment_content" name="" />
			  	<button type="button" id="ad_comment_bt" class="btn btn-default" @click="sub($event,ar['id'],0)">评论</button>
			  </div>
			</form>
		</div>

		<div class="ad_comment_list row" v-for="item in nowComment">
			<div class="ad_comment_lcontent">
				<div>
					<a :href="'/user/?id='+item['uid']" class="ad_comment_fupic">
						<img :src="'http://www.vueblog.com/'+item['headpic']" class="img-responsive">
					</a>
					<span ><a :href="'/user?id='+item['uid']" class="ad_comment_name">{{item['name']}}</a></span>
					<span v-if="item['uid'] == ar['uid']">[作者]</span>
					<span  v-if="item['to_user'] != null">
						<span>回复</span>
						<span><a :href="'/user?id='+item['to_user']['uid']"  class="ad_comment_name">{{item['to_user']['name']}}</a></span>
						<span v-if="item['to_user']['uid'] == ar['uid']">[作者]</span>
					</span>
					<span class="ad_comment_time">刚刚</span>
				</div>
				<div class="ad_comment_detail" style="word-break: break-all; word-wrap:break-word;">
					{{item['content']}}
				</div>
				<div class="ad_comment_do">
					<i class="fa fa-trash-o fa-mm" v-if="item['uid'] == userid" aria-hidden="true" style="margin-left:10px;" @click="commentDel($event,item['cid'],item['tid'])" ></i>
					<span v-if="item['uid'] == userid" >
						删除
					</span>
				</div>
			</div>
		</div>


		<div class="ad_comment_list row" v-for="(item,index) in comment" >
			
			<div class="ad_comment_lcontent">
				<div>
					<a :href="'/user?id='+item['from_id']" class="ad_comment_fupic">
						<img :src="'http://www.vueblog.com/'+item['from_user_headpic']" class="img-responsive">
					</a>
					<span ><a :href="'/user?id='+item['from_id']" class="ad_comment_name">{{item['from_user']['name']}}</a></span>
					<span v-if="item['from_id'] == ar['uid']">[作者]</span>

					<span  v-if="item['to_id'] != 0">
						<span>回复</span>
						<span><a :href="'/user?id='+item['to_id']"  class="ad_comment_name">{{item['to_user']['name']}}</a></span>
						<span v-if="item['to_id'] == ar['uid']">[作者]</span>
					</span>

					<span class="ad_comment_time" v-time="item['created_at']"></span>
				</div>
				<div class="ad_comment_detail" style="word-break: break-all; word-wrap:break-word;">
					{{item['content']}}
				</div>
				<div class="ad_comment_do">

					<i class="fa fa-thumbs-o-up fa-mm" v-if="item['isAgree'] == null " @click="agree($event,item['id'])" aria-hidden="true"></i>

					<i class="fa fa-thumbs-up agreed fa-mm"  style="color:#FF6666"  v-else @click="agree($event,item['id'])" aria-hidden="true"></i>
					<span >
						{{item['agree_count']}}
					</span>

					<i class="fa fa-commenting-o fa-mm" @click="hf = index" style="margin-left:10px;" aria-hidden="true"></i>
					<span>
						回复
					</span>

					<i class="fa fa-trash-o fa-mm" v-if="item['from_id'] == userid" aria-hidden="true" style="margin-left:10px;" @click="commentDel($event,item['id'],item['tid'])" ></i>
					<span v-if="item['from_id'] == userid" >
						删除
					</span>

					<div v-if="index == hf" style="margin-bottom:15px;margin-top:15px;margin-left:0px;" class="row">
						<form class="form-inline" >
						  <div class="form-group" style="width:100%">
							<input type="text" id="ad_comment_content" name="" />
						  	<button type="button" id="ad_comment_bt" class="btn btn-info" @click="sub($event,ar['id'],item['from_id'])">评论</button>
							<button type="button" class="btn btn-default"  style="margin-left:10px;float:left" @click="cqx">取消</button>
						  </div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				to_id:'0',
	        	content:'',
	        	comment:'',
	        	nowComment:[],
	        	hf:null,
	        	userid:'',
			}
		},
		props: {
	        ar: Object,
	        user: Object,
	        userdetail: Object,

    	},
    	mounted:function(){
    		this.userid = $('#headImg').attr('userid');
    		let tid = $('#ad_title').attr('tid');
    		// console.log(tid+'as-asdf');
    		let self = this;
    		axios.get('/article/getComment?tid='+tid)
			  .then(function (response) {
			  	self.comment = response['data'];			  	
			  	// console.log(self.comment);
			  })
			  .catch(function (error) {
			    console.log(error);
			  });
    	},
    	methods:{
    		sub:function(event,id,to_id){
    			let self = this;
    			this.content = event.target.previousElementSibling.value;
    			axios.post('/article/comment', {
    				content:self.content,
    				to_id:to_id,
    				tid:id,
    				comment_type:'article',
				})
				.then(function (response) {
				    console.log(response);
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
				    	default:
							new Swal({ 
							  title: "发布成功", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
							$('#ad_comment_content').val('');
							
							if(to_id == 0){
								self.nowComment.push(response['data']);
								var num = $('#ad_comment_count').text();
				    			num++;
				    			$('#ad_comment_count').text(num);
							}else{
								console.log(response['data']);
								self.nowComment.push(response['data']);
								self.hf=null;

							}

				    }
				})
				.catch(function (error) {
				    console.log(error);
				});
    		},
    		inputFunc:function(event){
    			console.log(event.target);
    		},
			agree:function(event,id){
	    		//点赞请求
				axios.get('/article/commentAgree?id='+id)
				  .then(function (response){
				  	console.log(response);
				    switch(response['data']){
				    	case 2:
					    	new Swal({ 
							  title: "请先登录", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    	case 0:
					    	event.target.style.color="#636B6F"
					    	event.target.nextElementSibling.innerText--
				    	break;
				    	case 1:
					    	event.target.style.color="#FF6666"
					    	event.target.nextElementSibling.innerText++
				    	break;
				    }

				  })
				  .catch(function (error) {
				    console.log(error);
				  });
	    	},
	    	//关闭回复评论
	    	cqx:function(){
	    		this.hf = null;
	    	},
	    	commentDel:function(event,id,tid){
				Swal({
				  title: '确定删除?',
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonText: '确定',
				  cancelButtonText: '取消'
				}).then((result) => {

				  if (result.value) {
				  		axios.get('/article/commentDel?id='+id+'&tid='+tid)
			    		.then(function(response){
			    			console.log(response);
			    			var num = $('#ad_comment_count').text();
			    			num--;
			    			$('#ad_comment_count').text(num);
			    			event.target.parentNode.parentNode.parentNode.remove()
			    		})
			    		.catch(function(error){
			    			console.log(error);
			    		})
				    Swal(
				      '删除成功',
				    )
				  // For more information about handling dismissals please visit
				  // https://sweetalert2.github.io/#handling-dismissals
				  } else if (result.dismiss === Swal.DismissReason.cancel) {
				    Swal(
				      '已取消',
				    )
				  }
				})
	    	}
    	}
    	
	}
</script>

