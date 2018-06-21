<template>
	<div id="a_main">
		<div id="ad_load" v-if="isLoad">
			<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
		</div>
		<div class="a_body" v-else v-for="item in question['data']">

			<div class="a_head"> 
				<span>相关话题:</span>
				<span v-for="top in item['topic']">
					<a :href="'/topic/detail?id='+top.id" class="a_topic">{{top['topic']}}</a>
				</span>
			</div>
			<div class="a_article_title">
				<span><a class="a_title" :href="'/question/detail?id='+item.id" target="_blank">{{item['title']}}</a></span>
			</div>

			<div class="a_article_user">
				<span>
					<a :href="'/user?id='+item['uid']" class="auser">
						<img :src="'http://www.vueblog.com/'+item['user']['headpic']"  style="height:30px;border-radius:7px;">
					</a>
				</span>
				<span>	
					<a :href="'/user?id='+item['uid']" class="ausername">
						{{item['user']['name']}}
					</a>
				</span>
				<span v-time="item['created_at']" class="atime">
					
				</span>
			</div>

			<div class="a_article_body">

			
			</div>

			<div class="a_article_foot">
				<i class="fa fa-thumbs-o-up fa-i" v-if="item['isAgree'] == null " @click="agree($event,item['id'])" aria-hidden="true"></i>

				<i class="fa fa-thumbs-up agreed fa-i"  v-else @click="agree($event,item['id'])" aria-hidden="true"></i>
				<span >
					{{item['agree_count']}}
				</span>


				<i class="fa fa-commenting-o fa-i" style="margin-left:10px;"  aria-hidden="true"></i> 
				<span>{{item['comment_count']}}</span>

				<i class="fa fa-star collection fa-i" style="color:#FF6666;margin-left:10px;" v-if="item['isCollection'] != null" @click="collection($event,item['id'])" aria-hidden="true"></i>

				<i class="fa fa-star-o collection fa-i"  style="margin-left:10px;"v-else @click="collection($event,item['id'])" aria-hidden="true"></i>

				<span v-if="item['isCollection'] == null" >收藏</span>
				<span v-else>已收藏</span>


				<!-- <i class="fa fa-eye" style="margin-left:10px;" aria-hidden="true"></i>
				<span>
					
				</span>
 -->
			</div>
		</div>


	</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return{
				question:[],
				isCollection:'',
        		collectionMes:'',
        		isLoad:true,
			} 
		},
		beforeMount: function () {
			let self = this;
         	axios.post('/question/getAll', {
			})
			.then(function (response) {
			  	self.question = response;
			  	self.isLoad = false;
			  	console.log(self.question);
			})
			  .catch(function (error) {
			    console.log(error);
			});
         
        },
        updated:function(){
        	$('.a_article_neirong').find('img').remove();
        },
        methods:{
        	agree:function(event,id){
        		//点赞请求
				axios.get('/question/agree?id='+id)
				  .then(function (response) {

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
        	collection:function(event,id){
    		let self = this;
    		axios.get('/question/collection?id='+id)
    		.then(function(response){
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
			    		new Swal({ 
						  title: "取消收藏", 
						  timer: 800, 
						  showConfirmButton: false 
						});
						event.target.style.color="#636B6F";
						self.isCollection = false;
						event.target.nextElementSibling.innerText = '收藏';
			    	break;
			    	case 1:
			    		new Swal({ 
						  title: "已收藏", 
						  timer: 800, 
						  showConfirmButton: false 
						});
						event.target.style.color="#FF6666";
						self.isCollection = true;
						event.target.nextElementSibling.innerText = '已收藏';
			    	break;
			    }

    		})
    		.catch(function(error){
    			console.log(error);
    		})
    	}
        }
     }
</script>

