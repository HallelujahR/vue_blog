<template>
	<div>
		<form class="form-inline">
			<input type="file" @change="picChange" ref="inputer" name="headpic" id="headpic" />
			<div class="form-group" id="headPic"  v-if="showUp" >
				<div @click="pic">
					<div id="camera">
					<i class="fa fa-camera fa-5x" aria-hidden="true"></i>
					</div>
					<div id="headPicFont">上传文章题图</div>


				</div>
				<img :src="dataUrl" id="viewPic" v-if="show" class="img-responsive">
			</div>

			<div class="form-group" id="headPic2"  v-else >
				<div id="changeBtn">
					<i class="fa fa-trash-o fa-2x changeP"  @click="clearPic" aria-hidden="true"></i>
					<i class="fa fa-exchange fa-2x changeP" @click="change" aria-hidden="true"></i>
				</div>
				<img :src="dataUrl" id="viewPic" v-if="show" class="img-responsive">
			</div>

			<div class="form-group" id="titleDiv">
				<input id="title" type="text" autofocus="autofocus" placeholder="输入文章的标题" required>
			</div>
			<div class="form-group">
				<div id="editorOneDiv">
					<div id="editorOne" ></div>
				</div>
				<div id="editorTwo" class="col-md-12" require>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">发布文章</button>
			</div>
		</form>
	</div>
</template>

<script type="text/javascript">
//引入富文本编辑器
window.onload=function(){
	var E = require('wangeditor');
	var editor = new E('#editorOne','#editorTwo');
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
    'list',  // 列表
    'justify',  // 对齐方式
    'quote',  // 引用
    'foreColor',  // 文字颜色
    'image',  // 插入图片
    'code',  // 插入代码
    'undo',  // 撤销
    'redo'  // 重复
    ]
    editor.customConfig.showLinkImg = false
    editor.customConfig.uploadImgShowBase64 = true;
	editor.create();
	editor.txt.html('<p>在此处输入文章内容</p>')
	}

	export default {
    data () {
        return {
            // 转base64码后的data字段
            dataUrl: '',
            show:false,
            showUp:true,
        }
    },
	  methods:{
	  	pic:function(){
	  		document.getElementById('headpic').click();
	  	},
	  	clearPic:function(){
	  		var file = document.getElementById('headpic');
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
	  		console.log(this.file);
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
	  	}
	  }
	}
</script>


