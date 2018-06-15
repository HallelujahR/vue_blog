
var Time = {
	//获取当前时间戳
	getUnix: function(){
		var date = new Date();
		return date.getTime();
	},
	//获取今天0点0分0秒的时间戳
	getTodayUnix: function(){
		var date = new Date();
		date.setHours(0);
		date.setMinutes(0);
		date.setSeconds(0);
		date.setMilliseconds(0);
		return date.getTime();
	},
	//获取今年1月1日0点0分0秒的时间戳
	getYearUnix: function(){
		var date = new Date();
		date.setMonth(0);
		date.setDate(1);
		date.setHours(0);
		date.setMinutes(0);
		date.setSeconds(0);
		date.setMilliseconds(0);
		return date.getTime();
	},
	//获取标准年月日
	getLastDate: function(time){
		var date = new Date(time);
		var month = date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1;
		var day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
		return date.getFullYear() + '-' + month + '-' + day;
	},
	//转换时间
	getFormatTime: function(timeStamp){
		var date1 = new Date(timeStamp);
    	// 有三种方式获取
    	var timeStamp = date1.getTime();
		var now = this.getUnix();	//当前时间戳
		var today = this.getTodayUnix();	//今天0点时间戳
		var year = this.getYearUnix();	//今年0点时间戳
		var timer = (now - timeStamp) / 1000;	//转换为秒级时间戳
		if(timer <= 0 || Math.floor(timer/60) <=0){
			return '刚刚';
		}
		if(timer < 3600){
			return Math.floor(timer/60) + '分钟前';
		}
		if(timer >=3600 && (timeStamp - today >= 0)){
			return Math.floor(timer/3600) + '小时前';
		}
		if(timer/86400 <= 31){
			return Math.ceil(timer/86400) + '天前';
		}
		return this.getLastDate(timeStamp);
		
	}
};
Vue.directive('time', {
	bind: function(el, binding){
		el.innerHTML = Time.getFormatTime(binding.value);
		el.__timeout__ = setInterval(function(){
			el.innerHTML = Time.getFormatTime(binding.value);
		}, 60000);
	},
	unbind: function(el){
		clearInterval(el.__timeout__);
		delete el.__timeout__;
	}
});


