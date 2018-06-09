<template>
	<div>
		<div>
			<form class="form-inline" >
			  <div class="form-group" style="width:100%">
				<input type="text" id="ad_comment_content" name="" />
			  	<button type="button" id="ad_comment_bt" class="btn btn-default" @click="sub($event,ar['id'])">评论</button>
			  </div>
			</form>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				to_id:'0',
	        	content:'',
			}
		},
		props: {
	        ar: Object,
	        user: Object,
	        userdetail: Object,
    	},
    	methods:{
    		sub:function(event,id){

    			let self = this;
    			this.content = $('#ad_comment_content').val();
    			axios.post('/article/comment', {
    				content:self.content,
    				to_id:self.to_id,
    				tid:'0',
    				comment_type:'article',
    				from_id:id,
				})
				.then(function (response) {
				    console.log(response);
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

