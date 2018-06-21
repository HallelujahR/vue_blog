<template>
	<div>
		<div id="as_load" v-if="isLoad" >
    		<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    	</div>
		<div v-else>
			 <div v-for="item of answer" class="answer_list" >
				<div class="answer_list_head">
					<span>
						<a :href="'/user?id='+item['uid']" class="auser">
							<img :src="'http://www.vueblog.com/'+item['headpic']" class="a_headpic">
						</a>
					</span>
					<span>	
						<a :href="'/user?id='+item['uid']" class="ausername">
							{{item['name']}}
						</a>
					</span>
				</div>

				<div class="answer_list_body" v-html="item['content']">
					
				</div>

				<div class="answer_list_time">
					<span>最后编辑于:{{item['updated_at']}}</span>
				</div>

				<div class="answer_list_action">
					<!-- 点赞 -->
					<span class="answer_list_action_a">
						<i class="fa fa-thumbs-o-up answer_list_action_i" aria-hidden="true"></i>
						<!-- <i class="fa fa-thumbs-up" aria-hidden="true"></i> -->
						<span class="answer_list_action_font">1</span>
					</span>
					<span class="answer_list_action_show">
						<!-- 评论按钮 -->
						<span class="answer_list_action_a">
							<i class="fa fa-comment-o answer_list_action_i" aria-hidden="true"></i>
							<span class="answer_list_action_font">1 条评论</span>
						</span>

						<!-- 收藏按钮 -->
						<span class="answer_list_action_a">
							<i class="fa fa-star-o answer_list_action_i" aria-hidden="true"></i>
							<span class="answer_list_action_font">收藏</span>
							<!-- <i class="fa fa-star" aria-hidden="true"></i> -->
						</span>
					</span>

				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return {
				answer:[],
				isLoad:true,
			}
		},
		props:{
			qid:String,
		},
		mounted(){
			let self = this;
			axios.post('/answer/getAnswer',{
				qid:this.qid,
			})
			.then((response) => {
				self.answer = response['data'];
				self.isLoad = false;
				console.log(response);
			})
		}
	}

</script>