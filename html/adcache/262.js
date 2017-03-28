    var content_str = "<link href='http://nginx100.com/admin/template/css/mainone_ads.css' type='text/css' rel='stylesheet' /><link href='http://nginx100.com/admin/template/css/GG.css' type='text/css' rel='stylesheet' /><style type='text/css'>#mainone_ads_LBGG {width:840px; height:400px;position:relative; overflow:hidden;margin-top:px;margin-left:px;}#mainone_ads_picBox { height:400px; width:840px;}#mainone_ads_picBox li{ height:400px;}</style><div class='mainone_ads_LBGG mainone_ads' id='mainone_ads_LBGG'><ul id='mainone_ads_picBox' style='top:0;'><li><a href='/content/Content/index/id/521'><img width='840' height='400'src='../../static/uploadfile/advert/2017_02/20170214164717_9437_55.png'/></a></li><li><a href='/content/Content/index/id/519'><img width='840' height='400'src='../../static/uploadfile/advert/2017_02/20170214164718_1967_49.jpg'/></a></li><li><a href='/content/Content/index/id/520'><img width='840' height='400'src='../../static/uploadfile/advert/2017_02/20170214164718_3197_42.jpg'/></a></li></ul><ul id='mainone_ads_liBox'><li class='active'>1</li><li >2</li><li >3</li></ul></div>";
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
	xxk.glide(true,'mainone_ads_liBox','mainone_ads_picBox',400,5,0.1,'top');
