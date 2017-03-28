    var content_str = "<link href='http://nginx100.com/admin/template/css/mainone_ads.css' type='text/css' rel='stylesheet' /><link href='http://nginx100.com/admin/template/css/GG.css' type='text/css' rel='stylesheet' /><style type='text/css'>#mainone_ads_LBGG {width:593px; height:360px;position:relative; overflow:hidden;margin-top:px;margin-left:px;}#mainone_ads_picBox { height:360px; width:593px;}#mainone_ads_picBox li{ height:360px;}</style><div class='mainone_ads_LBGG mainone_ads' id='mainone_ads_LBGG'><ul id='mainone_ads_picBox' style='top:0;'><li><a href='/content/Content/index/id/542'><img width='593' height='360'src='../../static/uploadfile/advert/2017_02/20170214171800_4612_65.jpg'/></a></li><li><a href='/content/Content/index/id/540'><img width='593' height='360'src='../../static/uploadfile/advert/2017_02/20170214171801_2203_69.jpg'/></a></li><li><a href='/content/Content/index/id/541'><img width='593' height='360'src='../../static/uploadfile/advert/2017_02/20170214171801_3403_89.png'/></a></li></ul><ul id='mainone_ads_liBox'><li class='active'>1</li><li >2</li><li >3</li></ul></div>";
	document.write(content_str);
	var xxk = new function(){
		function $id(id){
			return document.getElementById(id);
		}
		this.glide = function(auto,a,b,size,second,fSpeed,point){
			var oSubLi = $id(a).getElementsByTagName('li');
			var sum = oSubLi.length;
			var interval,timeout,Rang;
			var speed = fSpeed;
			var delay = second * 1000;
			var time = 5;
			var a = 0;
			var setValTop = function(s){
				return function(){
					Rang = Math.abs(parseInt($id(b).style[point]));
					$id(b).style[point] = -Math.floor(Rang + (parseInt(s * size) - Rang) * speed) + 'px';
					if(Rang == [(s * size)]){
						clearInterval(interval);
						a = s;
					}
				}
			}
			var setValDown = function(s){
				return function(){
					Rang = Math.abs(parseInt($id(b).style[point]));
					$id(b).style[point] = -Math.ceil(Rang + (parseInt(s * size) - Rang) * speed) + 'px';
					if(Rang == [(s * size)]){
						clearInterval(interval);
						a = s;
					}
				}
			}
			function autoGlide(){
				for(var c = 0; c < sum;c++){
					oSubLi[c].className = '';
				}
				clearInterval(timeout);
				if(a == (parseInt(sum) - 1)){
					for(var c = 0; c < sum;c++){
						oSubLi[c].className = '';
					}
					a = 0;
					oSubLi[a].className = 'active';
					interval = setInterval(setValTop(a),time);
					timeout = setTimeout(autoGlide,delay);
				}else{
					a++;
					oSubLi[a].className = 'active';
					interval = setInterval(setValDown(a),time);
					timeout = setTimeout(autoGlide,delay);
				}
			}
			timeout = setTimeout(autoGlide,delay);
			for(var i = 0;i < sum;i++){
				oSubLi[i].onmouseover = (function(i){
					return function(){
						for(var c = 0;c <sum;c++){
							oSubLi[c].className = '';
						}
						clearInterval(interval);
						clearTimeout(timeout);
						oSubLi[i].className = 'active';
						if(Math.abs(parseInt($id(b).style[point])) > [(size * i)]){
							interval = setInterval(setValTop(i),time);
							this.onmouseout = function(){
								timeout = setTimeout(autoGlide,delay);
							}
						}else if(Math.abs(parseInt($id(b).style[point])) < [(size * i)]){
							interval = setInterval(setValDown(i),time);
							this.onmouseout = function(){
								timeout = setTimeout(autoGlide,delay);
							}
						}
					}
				})(i);
			}
		}
	}
	xxk.glide(true,'mainone_ads_liBox','mainone_ads_picBox',360,5,0.1,'top');
