<template>
	<div>
		<div>
			<form class="form-inline" >
			  <div class="form-group" style="width:100%">
				<input type="text" class="form-control" placeholder="Text input" id="ad_comment_content">
			  	<button type="submit" id="ad_comment_bt" class="btn btn-default">评论</button>
			  </div>
			</form>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default{
		props: {
	        ar: Object,
	        user: Object,
	        userdetail: Object
    	},
    	
	}
</script>