<template>
	<div>
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

			<div class="form-group" id="headPic2"  v-else >
				<div id="changeBtn">
					<i class="fa fa-trash-o fa-2x changeP"  @click="clearPic" aria-hidden="true"></i>
					<i class="fa fa-exchange fa-2x changeP" @click="change" aria-hidden="true"></i>
				</div>
				<img :src="dataUrl" id="viewPic" v-if="show" class="img-responsive">
			</div>

			<div class="form-group" id="titleDiv">
				<input id="title" type="text" autofocus="autofocus" placeholder="输入文章的标题" maxlength="20" v-model="article.title" autocomplete="off" required>
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
					
					<i class="fa fa-search" aria-hidden="true"></i><input type="text" name="topic" id="searchTopic" v-model="query" v-on:input ="inputFunc" placeholder="选择文章标签,最多三个" autocomplete="off" />
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
					<div id="editorOne" ></div>
				</div>
				<div id="editorTwo" class="col-md-12" require>
				</div>
				 <textarea id="text1" style="display:none" name="html"></textarea>
			</div>
			<div class="form-group">
				<button type="submit"  id="getHtml" class="btn btn-success">发布文章</button>
			</div>
		</form>
	</div>
</template>
<script type="text/javascript">
//引入富文本编辑器
window.onload=function(){
		var E = require('wangeditor');
		const editor = new E('#editorOne','#editorTwo');
		//配置菜单
		 editor.customConfig.menus = [
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
	    'foreColor',  // 文字颜色
	    'code',  // 插入代码
	    'undo',  // 撤销
	    'redo'  // 重复
	    ]
	    editor.customConfig.showLinkImg = false
	    editor.customConfig.uploadImgShowBase64 = true;
	    var text1 = document.getElementById('text1')
 		editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea

            text1.value=html;
        }
		editor.create();
		editor.txt.html('<p>在此处输入文章内容</p>');
		document.getElementById('getHtml').onclick = function(){
			editor.txt.html('');
		}
		console.log(document.getElementById('re'));
	}


	export default {
    data () {
        return {
            // 转base64码后的data字段
            dataUrl: '',
            show:false,
            showUp:true,
            query: '',
		    list: [],
		    selectTopic:[],//这里是选中了哪个话题

		    article:{
		    	title:'',
		    	pic:'',
		    	html:'',
		    	topicid:[],
		    	// userid:'',
		    }
        }

    },
	mounted(){
	    this.init()
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

			this.article.html = document.getElementById('text1').value;
			//判断是否文本输入			
			if(this.article.html ==''){
				alert('请编写文章');
				return false;
			}
			//判断是标签是否选择
			if(this.article.topicid.length == 0){
				alert('请选择标签');
				return false;
			}
			this.article.pic = this.dataUrl;
			let self = this;
			axios.post('/article/createArticle', {
				article:self.article
			})
			.then(function (response) {
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
			  		self.query = '';
			  		location.reload()
				}else{
					alert('2');
				}
			})
			.catch(function (error) {
			    console.log(error);
			});
		},
		getHtml:function(){
		},
		init:function(){
			// console.log(document.getElementById('headImage'));
			console.log(document.getElementById('re'));
		},
		selectIs:function(e,topicid,topic){

			//禁止重复选择
			for(var i =0;i<this.selectTopic.length;i++){
				if(this.selectTopic[i]['id'] == topicid){
					return false;
				}
			}
			//最多选择三个
			if(this.selectTopic.length <3){
				this.selectTopic.push({id:topicid,topic:topic});
				this.article.topicid.push(topicid);
			}else{
				return false;
			}

	    },
	    deleteTopic:function(index){
	    	this.selectTopic.splice(index,1);
	    	this.article.topicid.splice(index,1);
	    	// alert(index);
	    },
	  	pic:function(){
	  		document.getElementById('headpic').click();
	  	},
	  	clearPic:function(){
	  		alert(1);
	  		var file = document.getElementById('headpic');
	  		this.dataUrl=null;
	  		file.value='';
	  		this.show=false;
	  		this.showUp=true;
	  	},
	  	change:function(){
	  		document.getElementById('headpic').click();
	  	},
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


	  }
	}
</script>


