<template>
	<div id="a_main">
		<div class="a_body" v-for="item in article['data']">
			<div class="a_head"> 
				<span>相关话题:</span>
				<span v-for="top in item['topic']">
					<a href="" class="a_topic">{{top['topic']}}</a>
				</span>
			</div>
			<div class="a_article_title">
				<span><a class="a_title" href="">{{item['title']}}</a></span>
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
				<i class="fa fa-thumbs-o-up" @click="agree($event,item['id'])" aria-hidden="true"></i>
				<span >
					{{item['agree_count']}}
				</span>

				<i class="fa fa-commenting-o" style="margin-left:10px;"  aria-hidden="true"></i> 
				<span>{{item['comment_count']}}</span>
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
				msg:'asdfasdasdfasdf',
				article:[],
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
        		//点赞请求s
				axios.get('/article/agree?id='+id)
				  .then(function (response) {
				    console.log(response);
				  })
				  .catch(function (error) {
				    console.log(error);
				  });
        	}
        }
     }

	
</script>