$(function(){
				var bigImg='';
				var _index=0;
				var word ='';
				$(".show span").click(function(){
					$(".show").hide();
					$(".popup").hide();
				});
				$(".center a").click(function(){
//					var content = $(this).find("p").html();
					$(".popup").show();
					$(".show").show();
					bigImg=$(this).find("img").attr("src");//获取点击图片的地址
					word=$(this).find("p").html();//点击获取当前文字
					//alert(bigImg);
					$(".show img.big").attr("src",bigImg); //更换大图的图片地址
					_index=$(this).index();//保存图片的序列号
					//alert(_index);
					$(".cont_dete").html(word);
				});
				$(".right").click(function(){
					_index++; //序列号加1 _index+1
					if(_index>20){_index=0};
					bigImg=$(".center a img").eq(_index).attr("src");
					word=$(".center a p").eq(_index).html();
					$(".show img.big").attr("src",bigImg);
					$(".cont_dete").html(word);
					
				});
				$(".left").click(function(){
					_index--; //序列号加1 _index+1
					if(_index<-1){_index=20};
					bigImg=$(".center img").eq(_index).attr("src");
					word=$(".center a p").eq(_index).html();
					$(".show img.big").attr("src",bigImg);
					$(".cont_dete").html(word);
				});
			})











