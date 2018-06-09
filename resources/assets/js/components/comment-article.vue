<template>
	<div id="ad_comment">
		<div>
			<form class="form-inline" >
			  <div class="form-group" style="width:100%">
				<input type="text" id="ad_comment_content" name="" />
			  	<button type="button" id="ad_comment_bt" class="btn btn-default" @click="sub($event,ar['id'])">评论</button>
			  </div>
			</form>
		</div>
		<div>
			
		</div>
<!-- 		<div class="ad_comment_list row" v-for="item in comment">
			<div class="ad_comment_pic col-md-2" style="border:1px solid red">
				<a href=""><img :src="'http://www.vueblog.com/'+item['from_user_headpic']" class="img-responsive"/></a>
			</div>
			<div class="ad_comment_right col-md-10" style="border:1px solid blue">
				<div>
					<span class="ad_comment_from_name">{{item['from_user']['name']}}</span>
					<span class="ad_comment_font">回复</span>
					<span class="ad_comment_to_name">Raven</span>
				</div>
				<div class="ad_comment_content_d">
					{{item['content']}}
				</div>
			</div>
		</div> -->
		
		<div class="row"  style="border:1px solid green" v-for="item in comment">
			<div class="col-md-2" style="border:1px solid red">
				<a href=""><img :src="'http://www.vueblog.com/'+item['from_user_headpic']" style="height:20px;" class="img-responsive"/></a>
			</div>
			<div class="col-md-10" style="border:1px solid red">
				<div>
					<span >{{item['from_user']['name']}}</span>
					<span >回复</span>
					<span >Raven</span>
				</div>
				<div >
					{{item['content']}}
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
			}
		},
		props: {
	        ar: Object,
	        user: Object,
	        userdetail: Object,
    	},
    	beforeMount:function(){
    		let self = this;
    		axios.get('/article/getComment', {})
			  .then(function (response) {
			  	self.comment = response['data']['data'];
			  	console.log(self.comment);
			    console.log(response);
			  })
			  .catch(function (error) {
			    console.log(error);
			  });
    	},
    	methods:{
    		sub:function(event,id){

    			let self = this;
    			this.content = $('#ad_comment_content').val();
    			axios.post('/article/comment', {
    				content:self.content,
    				to_id:self.to_id,
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
				    	case 1:
				    		new Swal({ 
							  title: "发布成功", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
							$('#ad_comment_content').val('');
				    	break;
				    	case 0:
				    		new Swal({ 
							  title: "发布失败", 
							  timer: 1200, 
							  showConfirmButton: false 
							});
				    	break;
				    }
				})
				.catch(function (error) {
				    console.log(error);
				});
    		},
    		inputFunc:function(event){
    			console.log(event.target);
    		}
    	}
    	
	}
</script>

