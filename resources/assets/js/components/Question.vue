<template>
	<div>
		<form class="form-inline" @submit.prevent="submit">


			<div class="form-group" id="titleDiv">
				<input id="title" type="text" autofocus="autofocus" placeholder="输入问题" maxlength="20" v-model="question.title" autocomplete="off" required>
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
					
					<i class="fa fa-search" aria-hidden="true"></i><input type="text" name="topic" id="searchTopic" v-model="query" v-on:input ="inputFunc" placeholder="选择问题标签,最多三个" autocomplete="off" />
					<ul id="selectul"  >
						<li class="selectTopic"  v-for="(item,index) in selectTopic" style="float:left">
							{{item.topic}}
							<input type="hidden" name="topicid" v-model="question.topicid">
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
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">发布问题</button>
			</div>
		</form>
	</div>
</template>
<script type="text/javascript">
	export default {
    data () {
        return {
            query: '',
		    list: [],
		    selectTopic:[],//这里是选中了哪个话题
		    question:{
		    	title:'',
		    	html:'',
		    	topicid:[],
		    	// userid:'',
		    },
		    editor:'',
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

			this.question.html = this.editor.txt.html();
			//判断是否文本输入			
			if(this.editor.txt.text() ==''){
				new Swal({ 
				  title: "请输入问题描述！", 
				  timer: 1500, 
				  showConfirmButton: false 
				});
				return false;
			}
			//判断是标签是否选择
			if(this.question.topicid.length == 0){
				new Swal({ 
				  title: "请选择标签", 
				  timer: 1500, 
				  showConfirmButton: false 
				});
				return false;
			}
			let self = this;
			axios.post('/question/createQuestion', {
				question:self.question
			})
			.then(function (response) {
				console.log(response);
				//成功清楚表单内的数据
				if(response['data'] == '1'){
					
			  		self.question.html ='';
			  		self.question.topicid=[];
			  		self.question.title='';
			  		self.selectTopic=[];
			  		self.list=[];
			  		self.editor.txt.html('');
			  		self.query = '';
			  		new Swal({ 
					  title: "发布成功", 
					  timer: 1500, 
					  showConfirmButton: false 
					});
			  		$('#rel').trigger('click');
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
		    'foreColor',  // 文字颜色
		    'code',  // 插入代码
		    'undo',  // 撤销
		    'redo'  // 重复
		    ]
		    this.editor.customConfig.showLinkImg = false
		    this.editor.customConfig.uploadImgShowBase64 = true;
			this.editor.create();
			this.editor.txt.html('<p>在此处输入问题描述</p>');

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
				//向topic更新数据 前台
				this.selectTopic.push({id:topicid,topic:topic});
				//给提交给后台的数据更新
				this.question.topicid.push(topicid);
			}else{
				return false;
			}

	    },
	    //删除已经选中的标签
	    deleteTopic:function(index){
	    	this.selectTopic.splice(index,1);
	    	this.question.topicid.splice(index,1);
	    	// alert(index);
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


