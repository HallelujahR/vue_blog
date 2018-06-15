<template>
	<div class="row" style="margin-top:20px;" id="small_edit">
		<form class="form-inline" @submit.prevent="submit">
			<input type="file" @change="picChange" ref="inputer" name="headpic" id="headpic" />
			<div class="form-group" id="headPic"  v-if="showUp" >
				<div @click="pic">
					<div id="camera">
						<i class="fa fa-camera fa-5x" aria-hidden="true"></i>
					</div>
					<div id="headPicFont">上传文章题图</div>
				</div>
			</div>

			<div class="form-group" id="headPic2" style="z-index:1"  v-else >
				<div id="changeBtn">
					<i class="fa fa-trash-o fa-2x changeP"  @click="clearPic" aria-hidden="true"></i>
					<i class="fa fa-exchange fa-2x changeP" @click="change" aria-hidden="true"></i>
				</div>
				<img :src="dataUrl" id="viewPic" v-if="show" class="img-responsive">
			</div>

			<div class="form-group" id="titleDiv">
				<input id="title" type="text" value="adsfasdf" autofocus="autofocus" placeholder="输入文章的标题" maxlength="20" v-model="article.title"autocomplete="off" required>
			</div>
			<div id="staggered-list-demo">
			  <transition-group
			    name="staggered-fade"
			    tag="ul"
			    v-bind:css="false"
			    v-on:before-enter="beforeEnter"
			    v-on:enter="enter"
			    v-on:leave="leave"
			    id="list-ul"
			    class="list-group"
			  >
			    <li
			      v-for="(item, index) in computedList"
			      v-bind:key="item.topic"
			      v-bind:data-index="index"
			      class="topic-li "
			      :topicid="item.id"
			      v-on:click="selectIs($event,item.id,item.topic)"
			    >{{ item.topic }}</li>
			  </transition-group>
			</div>
			<div class="form-group" id="topic">
						<i class="fa fa-search" style="float:left" aria-hidden="true"></i>
						<input type="text" name="topic" id="searchTopic" v-model="query" v-on:input ="inputFunc" placeholder="选择文章标签,最多三个" autocomplete="off" />
					<ul id="selectul"  >
						<li class="selectTopic"  v-for="(item,index) in selectTopic" style="float:left">
							{{item.topic}}
							<input type="hidden" name="topicid" v-model="article.topicid">
							<i class="fa fa-times deleteTopic" @click="deleteTopic(index)" aria-hidden="true"></i>
						</li>
						
					</ul>

			</div>


			<div class="form-group">
				<div id="editorOneDiv">
					<div id="editorOne" style="overflow:hidden" ></div>
				</div>
				<div id="editorTwo" class="col-md-12" require>
				</div>
			</div>
			<div class="form-group" style="margin-top:20px;">
				<button type="submit" class="btn btn-success">修改文章</button>
				<button type="button" @click="qxedit" id="qx" class="btn btn-default">取消修改</button>
			</div>
		</form>
	</div>
</template>
<script type="text/javascript">
	export default {
    data () {
        return {
            // 转base64码后的data字段
            dataUrl: this.ar['pic'],
            show:false,
            showUp:true,
            query: '',
		    list: [],
		    selectTopic:this.ar['topic'],//这里是选中了哪个话题

		    article:{
		    	title:this.ar['title'],
		    	pic:this.ar['pic'],
		    	html:this.ar['article'],
		    	topicid:[],
		    	id:this.ar['id']
		    },

		    editor:'',

		    test:1,
        }

    },
    props: {
        ar: Object,
        user: Object,
    },
	mounted(){
		this.article.topicid = this.ar['topicid'].split('/');
	    this.init();
	    if(this.dataUrl != null){
	    	this.showUp = false;
	    	this.show = true;
	    }
	     
	},
    computed: {
	    computedList: function () {
	      var vm = this
	      return this.list.filter(function (item) {
	        return item.topic.toLowerCase().indexOf(vm.query.toLowerCase()) !== -1
	      })
	    },
	  },
	methods:{
		submit:function(){
			this.article.html = this.editor.txt.html();
			//判断是否文本输入			
			if(this.editor.txt.text() ==''){
				new Swal({ 
				  title: "请编写文章！", 
				  timer: 1500, 
				  showConfirmButton: false 
				});
				return false;
			}
			//判断是标签是否选择
			if(this.article.topicid.length == 0){
				new Swal({ 
				  title: "请选择文章标签", 
				  timer: 1500, 
				  showConfirmButton: false 
				});
				return false;
			}
			this.article.pic = this.dataUrl;
			let self = this;
			axios.post('/article/edit', {
				article:self.article
			})
			.then(function (response) {
				console.log(response);
				//成功清楚表单内的数据
				if(response['data'] == '1'){
					var file = document.getElementById('headpic');
			  		self.dataUrl=null;
			  		file.value='';
			  		self.show=false;
			  		self.showUp=true;
			  		self.article.html ='';
			  		self.article.topicid=[];
			  		self.article.pic = '';
			  		self.article.title='';
			  		self.selectTopic=[];
			  		self.list=[];
			  		self.editor.txt.html('');
			  		self.query = '';
			  		new Swal({ 
					  title: "修改成功", 
					  timer: 1500, 
					  showConfirmButton: false 
					});
			  		$('#qx').trigger('click');
				}else{
					alert('2');
				}
			})
			.catch(function (error) {
			    console.log(error);
			});
		},
		init:function(){

			//引入富文本编辑器
			let self = this;
			// console.log(document.getElementById('headImage'));
			this.editor = new E('#editorOne','#editorTwo');

				//配置菜单
			this.editor.customConfig.menus = [
		 	'head',  // 标题
		    'bold',  // 粗体
		    'fontSize',  // 字号
		    'fontName',  // 字体
		    'italic',  // 斜体
		    'underline',  // 下划线
		    'strikeThrough',  // 删除线
		    'link',  // 插入链接
		    'image',  // 插入图片
		    
		    'quote',  // 引用
		    'justify',  // 对齐方式
		    'list',  // 列表
		    'code',  // 插入代码
		    'undo',  // 撤销
		    'redo'  // 重复
		    ]
		    this.editor.customConfig.showLinkImg = false
		    this.editor.customConfig.uploadImgShowBase64 = true;
		    // this.editor.customConfig.uploadImgServer = '/upload'
			this.editor.create();
			this.editor.txt.html(this.article.html);
			console.log(this.article);

		},
		selectIs:function(e,topicid,topic){

			//禁止重复选择
			for(var i =0;i<this.selectTopic.length;i++){
				if(this.selectTopic[i]['id'] == topicid){
					return false;
				}
			}
			//最多选择三个2.
			if(this.selectTopic.length <3){
				//向topic更新数据 前台
				this.selectTopic.push({id:topicid,topic:topic});
				//给提交给后台的数据更新
				this.article.topicid.push(topicid);
			}else{
				return false;
			}

	    },
	    //删除已经选中的标签
	    deleteTopic:function(index){
	    	this.selectTopic.splice(index,1);
	    	this.article.topicid.splice(index,1);
	    	// alert(index);
	    },
	    //题图的点击
	  	pic:function(){
	  		document.getElementById('headpic').click();
	  	},
	  	//清除题图
	  	clearPic:function(){
	  		var file = document.getElementById('headpic');
	  		this.dataUrl=null;
	  		file.value='';
	  		this.show=false;
	  		this.showUp=true;
	  	},
	  	//改变题图
	  	change:function(){
	  		document.getElementById('headpic').click();
	  	},
	  	//转换为base64文件并且产出所缩略图
	  	imgPreview (file) {
	        let self = this;
	        // 看支持不支持FileReader
	        if (!file || !window.FileReader) return;

	        if (/^image/.test(file.type)) {
	            // 创建一个reader
	            var reader = new FileReader();
	            // 将图片将转成 base64 格式
	            reader.readAsDataURL(file);
	            // 读取成功后的回调
	            reader.onloadend = function () {
	                self.dataUrl = this.result;
	                self.show = true;
	                self.showUp=false;
	                
	            }
	        }
	    },
	  	picChange:function(e){
	  		let inputDOM = this.$refs.inputer;
	  		this.file    = inputDOM.files[0];
	  		this.article.pic = this.file;
	  		console.log(this.article.pic);
	  		 let size = Math.floor(this.file.size / 1024);
	        if (size > 3000) {
	            // 这里可以加个文件大小控制
	            return false
	        }
	        let array = ['image/jpeg','image/png','image/jpg'];
	        if(array.indexOf(this.file.type) == '-1'){
	        	return false;
	        }

	        // 触发这个组件对象的input事件
	        this.$emit('input', this.file);
	        
	        // 这里就可以获取到文件的名字了
	        this.fileName = this.file.name;
	        
	        // 这里加个回调也是可以的
	        this.onChange && this.onChange(this.file, inputDOM.value);

	        this.imgPreview(this.file);
	  	},
	  	getTopic:function(){
	  	},
	  	beforeEnter: function (el) {
		  el.style.opacity = 0
		  el.style.height = 0
		},
	    enter: function (el, done) {
	      var delay = el.dataset.index * 150
	      setTimeout(function () {
	        Velocity(
	          el,
	          { opacity: 1, height: '1.6em' },
	          { complete: done }
	        )
	      }, delay)
	    },
	    leave: function (el, done) {
	      var delay = el.dataset.index * 150
	      setTimeout(function () {
	        Velocity(
	          el,
	          { opacity: 0, height: 0 },
	          { complete: done }
	        )
	      }, delay)
	    },
	   inputFunc:function(e){
	   			let self = this;
	   			var time = 2;

			   	var timer = setInterval(function(){
				    for(var i=0;i<time;i++){
				    	if(i==1){
					   		const TOPIC = document.getElementById('searchTopic').value;
							axios.post('/getTopic', {
							      topic: TOPIC
							  })
							  .then(function (response) {
							    if(response.data != []){
							  		self.list = response.data;
							    }else{
							    	self.list=[];
							    }
							  })
							  .catch(function (response) {
							    console.log(response);
							  });
				    		clearInterval(timer);
				    	}
				    }
				},500);   		
	    },
	    qxedit:function(){
	    	$('#editbt').trigger('click');
	    }

	  }
	}
</script>


