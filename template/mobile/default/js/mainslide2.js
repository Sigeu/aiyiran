function A(){
	this.easeOut=function(t,b,c,d,s){
		if (s == undefined) s = 1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		//return -c * ((t=t/d-1)*t*t*t - 1) + b;
	}
	var that=this;
	this.pos=0;
	this.num=0;
	this.w=320;
	this.T=0;
	this.D=20;
	this.TT=null;
	this.maxNum=0;
	this.box=null;
	this.imgs=null;
	this.node=null;
	this.nodeClass='on';
	this.autoPlay=true;
	this.turnL=function(){
		clearTimeout(that.TT);
		that.T=0;
		if(that.num>0){
			that.num--;
		}else{
			//return false;
			that.num=that.maxNum;
		}	
		that.run();
	};
	this.turnR=function(){
		clearTimeout(that.TT);
		that.T=0;
		if(that.num<that.maxNum){
			that.num++;
		}else{
			//return false;
			that.num=0;
		}	
		that.run();		
	};
	this.init=function(opt){
		that.box=opt.box;
		that.imgs=opt.imgs;
		that.node=opt.node;
		if(opt.node===undefined){
			that.nodeClass=opt.node||'on';
		}			
		if(opt.autoPlay!==undefined){
			that.autoPlay=!!opt.autoPlay;
		}		
		if(that.autoPlay){	
			console.log(that.autoPlay)
			that.run();
		}
		that.w=that.box.width();
		console.log(that.box.width());
		that.maxNum=that.imgs.find('li').length-1;
		console.log(that.imgs.find('li').length);
		if(that.node){
			that.node.removeClass(that.nodeClass);
			$(that.node[that.num]).addClass(that.nodeClass);
		}	
	}
	this.run=function(){		
		function run(){	
				that.w=that.box.width();
				if(that.node){
					that.node.removeClass(that.nodeClass);
					$(that.node[that.num]).addClass(that.nodeClass);
				}				
				S=Math.ceil(that.easeOut(that.T,that.pos,that.num*that.w-that.pos,that.D));
				that.imgs.css({'margin-left':(-S)+'px'});
				that.pos=S
				if(that.T<that.D){
					that.T++;
					that.TT=setTimeout(run,80);
				}else{
					if(that.autoPlay){
						that.T=0;
						if(that.num<that.maxNum){
							that.num++;			
							that.TT=setTimeout(run,1000);
						}else{
							that.num=0;
							//A.pos=0;
							that.imgs.css({'margin-left':'0px'});
							//arr[1].style.marginLeft='0px';
							run();
						}	
						
					}
				}	
		}
		run();
	
}

}
if($('.pic_scroll').length>0){
	/*
	opt={box:obj,imgs:obj,node:obj,nodeClass:str,autoPlay:bool}*/
	var imgs=$('.pic_scroll ul:eq(0)');
	var img_span=$('.pic_scroll .pic_node li');
	//var btns =A.getClassTag(tags,'button','div')[0];
	imgs.css('margin-left','0');
	//fonts.style.marginLeft="0px";
	//var bts=btns.getElementsByTagName('a');
	var a=new A();
	a.init({box:$('.pic_scroll'),imgs:imgs,node:img_span});

	$('#prev').click(function(){
		a.turnL();
	})+
	$('#next').click(function(){
		a.turnR();
	})
}
if($('.pro_pic').length>0){
	var imgs2=$('.pic_list');
	var img_span2=$('.pro_pic .pic_node li');
	//var btns =A.getClassTag(tags,'button','div')[0];
	imgs2.css('margin-left','0');
	//fonts.style.marginLeft="0px";
	//var bts=btns.getElementsByTagName('a');
	var b=new A();
	b.init({box:$('.pro_pic'),imgs:imgs2,node:img_span2});
	$('.pro_ps .pro_prev').click(function(){
		b.turnL();
		return false;
	})+
	$('.pro_ps .pro_next').click(function(){
		b.turnR();
		return false;
	})
}







