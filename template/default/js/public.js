$(function(){

	$(".left_menu ul li:last").css("border","none")
	// 纪念馆二级菜单--yc
			    $(".navUl_yc>li").hover(function(){
			    	$(this).addClass("active");
//			    	$(this).children("a").addClass("active");
			    	$(this).children(".memNav_yc").stop().slideDown();
			    },function(){
//			    	$(this).children("a").removeClass("active");
                    
                    $(this).removeClass("active");
			    	$(this).children(".memNav_yc").stop().slideUp();
			    });
	
	          //下拉
				$('.seleBox').click(function() {
			        var isTrue = $(this).is('.on');
			        if(isTrue){
			            $(this).find('ul').slideUp();
			            $(this).find('i').removeClass('jt_2');
			            $(this).removeClass('on');
			        }else{
			            $(this).find('ul').slideDown();
			            $(this).find('i').addClass('jt_2');
			            $(this).addClass('on');
			        }
			        $(this).siblings().removeClass('on');
			        $(this).siblings().find('ul').slideUp();
			    });
			    $('.sel_list li').click(function(ev) {
			    	var $sel_active=$('#sel_active');
			        ev.stopPropagation();
			        if($(this).index()==$sel_active.index()){
			        	$(this).parents('.seleBox').removeClass('on').find('p').text($(this).text());
			        	$(this).parent().hide();
			        	$(this).parents('.seleBox').find('i').removeClass('jt_2');
			        	$('.sear_text').css('display','block');
			        }else{
			        	$(this).parents('.seleBox').removeClass('on').find('p').text($(this).text());
			        	$(this).parent().hide();
			        	$(this).parents('.seleBox').find('i').removeClass('jt_2');
			        	$('.sear_text').css('display','none');
			        }
			    });
			    /***list_zc******************************/
			    $(".list_zc li:even").addClass("lt");
			     $(".list_zc li").hover(function(){
			    	$(this).addClass("active");
			    },function(){
                    $(this).removeClass("active");
			    });
			    /****************/
			    $(".hotP ul li").hover(function(){
			    	$(this).addClass("active");
			    },function(){
                    $(this).removeClass("active");
			    });
			    
});

// 私人纪念馆搜索接口
function ityzl_SHOW_LOAD_LAYER(){
    return index = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
}
function ityzl_CLOSE_LOAD_LAYER(index){
    layer.close(index);
}

function sousuo(catid){
    var text = $('#searchMuseumkey').val();
    var type = 1; //搜索类型

    if (text == "") return false;
        $.ajax({
            type: "Post",
            url: "/search2/Search/input",
            data: {'text':text, 'type':type, 'catid':catid},
            dataType: "json",
            beforeSend: function () {
                i =ityzl_SHOW_LOAD_LAYER();
                // $('#sub').val('发表追思留言中...');
            },
            complete: function () {
                ityzl_CLOSE_LOAD_LAYER(i);
                // $('#sub').val('发表追思留言');
            },
            success: function(data) {
                if (data.status==1) {
                    var str = "";
                    for(var i=0; i<data.data.length; i++){
                        str += "<li>";
                        str += "<a href=/jinian/Jinian/index/mid/"+data.data[i].id+" target='_blank'>";
                        str += "<img src="+data.data[i].userpic+" />";
                        str += "<p class='clearfix'><span href='' class='fl nameA'>"+data.data[i].personname+"</span><span href='' class='fr'>"+data.data[i].persontype_name+"</span></p>";
                        str += "</a>";
                        str += "</li>";
                    }
                    $(".createData").html('');
                    $(".createData").html(str);
                }else{
                    $(".createData").html('');
                    $(".createData").html(data.msg);
                }
            }
        });

}


function sousuo2(text,type,catid){
    if (text == "") return false;
    $.ajax({
        type: "Post",
        url: "/search2/Search/input",
        data: {'text':text, 'type':type,'catid':catid},
        dataType: "json",
        beforeSend: function () {
            i =ityzl_SHOW_LOAD_LAYER();
            // $('#sub').val('发表追思留言中...');
        },
        complete: function () {
            ityzl_CLOSE_LOAD_LAYER(i);
            // $('#sub').val('发表追思留言');
        },
        success: function(data) {
            if (data.status==1) {
                var str = "";
                for(var i=0; i<data.data.length; i++){
                    str += "<li>";
                    str += "<a href=/jinian/Jinian/index/mid/"+data.data[i].id+" target='_blank'>";
                    str += "<img src="+data.data[i].userpic+" />";
                    str += "<p class='clearfix'><span href='' class='fl nameA'>"+data.data[i].personname+"</span><span href='' class='fr'>"+data.data[i].persontype_name+"</span></p>";
                    str += "</a>";
                    str += "</li>";
                }
                $(".createData").html('');
                $(".createData").html(str);
            }else{
                $(".createData").html('');
                $(".createData").html(data.msg);
            }
        }
    });

}

//点击分类样式 - 私人
$(function () {
   $(".tab_box li").click(function () {
      $(this).addClass('active').siblings('li').removeClass('active');
   });
    $(".SearchMuseum .rank li").click(function () {
    });
});

//点击分类样式 - 私人





//名人纪念馆搜索接口
function sousuos(catid){
    var text = $('#searchMuseumkey').val();
    var type = 1; //搜索类型

    if (text == "") return false;
    $.ajax({
        type: "Post",
        url: "/search2/Search/celebrity",
        data: {'text':text, 'type':type, 'catid':catid},
        dataType: "json",
        beforeSend: function () {
            i =ityzl_SHOW_LOAD_LAYER();
            // $('#sub').val('发表追思留言中...');
        },
        complete: function () {
            ityzl_CLOSE_LOAD_LAYER(i);
            // $('#sub').val('发表追思留言');
        },
        success: function(data) {
            if (data.status==1) {
                var str = "";
                for(var i=0; i<data.data.length; i++){
                    str += "<li>";
                    str += "<div class='hotPImg'>";
                    str += "<img src="+data.data[i].userpic+" width='214' height='214'>";
                    str += "</div>";
                    str += "<p class='clearfix hotP_p'><a href=/jinian/Jinian/index/mid/"+data.data[i].id+" class='fl nameA'>"+data.data[i].personname+"</a><a href=/jinian/Jinian/index/mid/"+data.data[i].id+" class='fr quickJS'>立即祭拜</a></p>";
                    str += "<div class='mainP'>";
                    str += "<p>享年：<span>"+data.data[i].m_year+"-"+data.data[i].d_year+"</span></p>";
                    str +="<p class='introP'>简介：<span>"+data.data[i].descript+"</span></p>";
                    str += "</div>";
                    str += "</li>";
                }
                $(".createData").html('');
                $(".createData").html(str);
            }else{
                $(".createData").html('');
                $(".createData").html(data.msg);
            }
        }
    });
}

function sousuos2(text, type, catid){
    if (text == "") return false;
    $.ajax({
        type: "Post",
        url: "/search2/Search/celebrity",
        data: {'text':text, 'type':type, 'catid':catid},
        dataType: "json",
        beforeSend: function () {
            i =ityzl_SHOW_LOAD_LAYER();
            // $('#sub').val('发表追思留言中...');
        },
        complete: function () {
            ityzl_CLOSE_LOAD_LAYER(i);
            // $('#sub').val('发表追思留言');
        },
        success: function(data) {
            if (data.status==1) {
                var str = "";
                for(var i=0; i<data.data.length; i++){
                    str += "<li>";
                    str += "<div class='hotPImg'>";
                    str += "<img src="+data.data[i].userpic+" width='214' height='214'>";
                    str += "</div>";
                    str += "<p class='clearfix hotP_p'><a href=/jinian/Jinian/index/mid/"+data.data[i].id+" class='fl nameA'>"+data.data[i].personname+"</a><a href=/jinian/Jinian/index/mid/"+data.data[i].id+" class='fr quickJS'>立即祭拜</a></p>";
                    str += "<div class='mainP'>";
                    str += "<p>享年：<span>"+data.data[i].m_year+"-"+data.data[i].d_year+"</span></p>";
                    str +="<p class='introP'>简介：<span>"+data.data[i].descript+"</span></p>";
                    str += "</div>";
                    str += "</li>";
                }
                $(".createData").html('');
                $(".createData").html(str);
            }else{
                $(".createData").html('');
                $(".createData").html(data.msg);
            }
        }
    });
}



/*******************************************/
// 确认登录吗
function isLogin()
{
    layer.confirm('你还未登录，请登录后操作', {
        btn: ['登录','取消'] //按钮
    }, function(){
        location.href = "/user/Login/login2";
    }, function(){
        window.location.reload();
        layer.closeAll();
    });
}




