<template>
<div id="ad_body">
    <div v-if="edit">
        <div class="container" style="margin-top:60px;">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <article-edit
                    :ar="ar"
                    :user="user"
                    ></article-edit> 
                </div>
            </div>
        </div>
    </div>
    <div v-else>
    	<div id="ad_load" v-if="isLoad" >
    		<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    	</div>
        <div class="container" style="margin-top:60px;"  v-else>
            <div class="col-md-offset-2 col-md-8"  id="ad_main" v-if="ar['pic'] !== '0' ">
                <img :src="ar['pic']" class="img-responsive">
            </div>

            <div class="col-md-offset-2 col-md-8" id="ad_title" :tid="aid">
                <span>{{ar['title']}}</span>
            </div>

            <div class="col-md-offset-2 col-md-8" id="ad_user">
                <div id="ad_user_pic">
                    <a :href="'/user?id='+userdetail['uid']">
                        <img :src="'http://www.vueblog.com/'+userdetail['headpic']" class="img-responsive" style="height:50px;">
                    </a>
                </div>
                <div id="ad_user_name">
                    <span id="ad_user_name1">{{user['name']}}</span>
                    <br>
                	<span>{{userdetail['Occupation']}}</span>
                </div>

            </div>
            <div>
            <div class="col-md-offset-2 col-md-8" v-html="ar.article" id="ad_article">
            	
            </div>
            </div>

            <div class="col-md-offset-2 col-md-8" id="ad_time">
            	<span>最后编辑于:{{ar['updated_at']}}</span>
            </div>

            <div class="col-md-offset-2 col-md-8" id="ad_topic">
            	<span v-for="topic in ar.topic" class="ad_topicc">
            		<a :href="'/topic/detail?id='+topic['id']" class="ad_topic_a"  style="color:white">{{topic['topic']}}</a>
            	</span>
            </div>
            <div class="col-md-offset-2 col-md-8" id="ad_foot">
            		<i class="fa fa-thumbs-o-up fa-mm" v-if="ar['isAgree'] == null " @click="agree($event,ar['id'])" aria-hidden="true"></i>

    				<i class="fa fa-thumbs-up agreed fa-mm"  style="color:#FF6666"  v-else @click="agree($event,ar['id'])" aria-hidden="true"></i>
    				<span >
    					{{ar['agree_count']}}
    				</span>


    				<i class="fa fa-commenting-o fa-mm" style="margin-left:10px;"  aria-hidden="true"></i> 
    				<span id="ad_comment_count">{{ar['comment_count']}}</span>


    				<i class="fa fa-star collection fa-mm" style="color:#FF6666" v-if="isCollection" @click="collection($event,ar['id'])" aria-hidden="true"></i>
    				<i class="fa fa-star-o collection fa-mm"  v-else @click="collection($event,ar['id'])" aria-hidden="true"></i>

    				<span>{{collectionMes}}</span>


                    <i class="fa fa-cog fa-set" aria-hidden="true" v-if="user['id'] == userid" @click="show = !show"></i>
                    <transition name="fade">
                        <span v-if="show" id="ad_edit">
                            <span>
                                <a href="#" @click="ad_del($event,ar['id'])">删除</a>
                            </span>
                            <span>
                                <a href="#" @click="ad_edit($event,ar['id'])">编辑</a>
                            </span>
                        </span>
                    </transition>




            </div>
    	    <div class="col-md-offset-2 col-md-8 ad_comment_a" >
    	    	<div id="ad_comment_a_font"  v-if="isComment">
    	    		还没有评论
    	    	</div>
    			<comment-article 
    			:ar="ar"
    			:user="user"
    			:userdetail="userdetail"
    			></comment-article>	
    		</div>
        </div>
    </div>
<span id="editbt" style="display:none" @click="Helpedit"></span>

</div>
</template>

<script type="text/javascript">
	export default({
    data(){
    	return {
            ar:[],
            aid:'',
            user:'',
            userdetail:'',
            isCollection:'',
            collectionMes:'',
            isComment:'',
            isLoad:true,
            show:'',
            userid:'',
            edit:false,
    	}
    },
    beforeMount:function(){
        this.init();
    },
    updated:function(){
    	$('#ad_article').find('img').addClass('img-responsive');
    },
    methods:{
        init:function(){
            this.userid = $('#headImg').attr('userid');
            let self = this;
            this.aid = this.GetQueryString('id=');
            axios.post('/article/detail', {
                id:this.aid,
            })
            .then(function (response) {
                self.isLoad = false;
                self.ar = response['data'];
                self.user = self.ar['user'];
                self.userdetail = self.ar['userdetail'];
                console.log(self.ar);
                if(self.ar['isCollection'] == null){
                    self.isCollection = false;
                    self.collectionMes = '收藏';
                }else{
                    self.isCollection = true;
                    self.collectionMes = '已收藏';
                }

                if(self.ar['comment_count'] == 0){
                    self.isComment = true;
                }else{
                    self.isComment = false;
                }
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
    	agree:function(event,id){
    		//点赞请求
			axios.get('/article/agree?id='+id)
			  .then(function (response){

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
    	},
        ad_del:function(event,id){
                Swal({
                  title: '确定删除?',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: '确定',
                  cancelButtonText: '取消'
                }).then((result) => {

                  if (result.value) {
                    axios.get('/article/delete?id='+id)
                        .then(function(response){
                            Swal(
                              '删除成功',
                            )
                            console.log(response);
                            
                        })
                        .catch(function(error){
                            console.log(error);
                        })
                  // For more information about handling dismissals please visit
                  // https://sweetalert2.github.io/#handling-dismissals
                  } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal(
                      '已取消',
                    )
                  }
                })
        },
        Helpedit:function(){
            this.init();
            this.edit= !this.edit;
        },
        //修改文章
        ad_edit:function(event,id){
            $('#editbt').trigger('click');
        }

    }
})
</script>