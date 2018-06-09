<template>
	<div id="a_main">
		<div class="a_body" v-for="item in article['data']">
			<div class="a_head"> 
				<span>相关话题:</span>
				<span v-for="top in item['topic']">
					<a :href="'/topic/detail/'+top.id" class="a_topic">{{top['topic']}}</a>
				</span>
			</div>
			<div class="a_article_title">
				<span><a class="a_title" :href="'/article/detail?id='+item.id" target="_blank">{{item['title']}}</a></span>
			</div>
			<div class="a_article_body">

				<div class="col-md-4 a_article_pic" v-if="item['pic'] !== '0' ">
					<!-- 文章题图 -->
					<img :src="item['pic']" class="img-responsive"/>
					<!-- {{item['pic']}} -->
				</div>

				<div v-if="item['pic'] !== '0' " class="col-md-8 a_article_neirong"  v-html="item['article']">
					<!-- 文章内容 -->
				</div>

				<div v-else class="col-md-12 a_article_neirong"  v-html="item['article']">
					<!-- 文章内容 -->
				</div>
				<div class="a_article_detail">
				</div>
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
				article:[],
				isCollection:'',
        		collectionMes:'',
			} 
		},
		beforeMount: function () {
			let self = this;
         	axios.post('/article/getAll', {
			})
			.then(function (response) {
			  	self.article = response;
			  	console.log(self.article);
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
				axios.get('/article/agree?id='+id)
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
    		axios.get('/article/collection?id='+id)
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

