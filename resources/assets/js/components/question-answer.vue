<template>
	<div>
		<div id="as_load" v-if="isLoad" >
    		<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    	</div>
		<div v-else>
			 <div v-for="(item,index) of answer" class="answer_list" >
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
					<span class="djzk" @click="answer_ak($event,index)">∨点击展开</span>
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
				isZk:false,
			}
		},
		props:{
			qid:String,
		},
		updated(){
			for(var i= 0;i<$('.answer_list_body').length;i++){
				if($('.answer_list_body:eq('+i+')').height() < 150 && $('.answer_list_body:eq('+i+')').find('img').length < 1 ){
					$('.answer_list_time:eq('+i+')').css({'display':'none'})
				}else{
					if($('.answer_list_body:eq('+i+')').find('img').length > 0){
						$('.answer_list_body:eq('+i+')').prepend($('.answer_list_body:eq('+i+')').find('img:eq('+0+')').clone().css({
							'float':'left',
							'height':'150px',
							'opacity':'1',
							'margin-right':'20px',
						})) 
					}
					$('.answer_list_body:eq('+i+')').css({'height':'150px',});
				}
			}		

			$('.answer_list_body').find('img:not(:first)').css({
				'opacity':'0',
				'height':'0px',
				'width':'0px',
				'transition':'all 0.3s',
			})
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
		},
		methods:{
			answer_ak:function(event,index){
				if(!this.isZk){
					//展开
					$('.answer_list_body:eq('+index+')').find('img:eq('+0+')').css({
						// 'float':'left',
						'height':'0px',
						'opacity':'0',
						'width':'0px',
						'transition':'all 0.3s',
					});

					$('.answer_list_body:eq('+index+')').css({
						'height':'auto',
					})
					$('.answer_list_body:eq('+index+')').find('img:not(:first)').css({
						// 'display':'none'
						'height':'auto',
						'width':'auto',
						'opacity':'1',
						'transition':'all 0.4s',
						'float':'none',
					});
					this.isZk = !this.isZk;
					event.target.innerHTML = '∧点击收起';
				}else{
					//收起
					$('.answer_list_body:eq('+index+')').find('img:eq('+0+')').css({
						'height':'150px',
						'opacity':'1',
						'width':'auto',
						'transition':'all 0.3s',
					});

					$('.answer_list_body:eq('+index+')').css({
						'height':'150px',
					});
					$('.answer_list_body:eq('+index+')').find('img:not(:first)').css({
						'opacity':'0',
						'height':'0px',
						'width':'0px',
						'transition':'all 0.3s',
					})
					this.isZk = !this.isZk;
					event.target.innerHTML = '∨点击展开';
				}
				
			}
		}
	}

</script>