(function( $ ){         
    var target = null;
    var template = null;
    var variables = {
        'last'      :    0        
    }

    var count = 0;
    var settings = {
        'amount'      :   '10',              //每次加载个数
        'address'     :   'data.php',        //数据请求地址
        'format'      :   'json',            //数据类型
        'template'    :   '.single_item',    //单条数据class
        'trigger'     :   '.get_more',       //更多链接class
        'no_data'     :   '.empty',         //更多链接class
        'before'      :   '#before',        //数据插入before之前
        'title_count' :   '10',             //标题个数
        'brief_count' :   '60',             //简介个数
    }
    
    var methods = {
        init : function(options){
            return this.each(function(){
                if(options){
                    $.extend(settings, options);
                }
                template = $(this).children(settings.template).wrap('<div/>').parent();
                template.css('display','none')
                $(this).append('<div class="more_loader_spinner"></div>');//loading图标
                $(this).children(settings.template).remove()   
                target = $(this);                   
                $(settings.trigger).bind('click.more',methods.get_data);
                $(this).more('get_data');
            })
        },
    
        remove : function(){
            $(settings.trigger).unbind('.more');
            target.unbind('.more')
            $(settings.trigger).remove();
        },
        
        add_elements : function(data){
            var root = target       
            var counter = 0;
            if(data){
                $(data).each(function(){
                    counter++
                    var t = template                    
                    $.each(this, function(key, value){                          
                        if(t.find('.'+key)) {
                            if (key == 'url') {
                                t.find('.'+key).attr('href', value);
                            }
                            else if (key == 'src') {
                                t.find('.'+key).attr('src', value);
                            } else {
                                t.find('.'+key).text(value);
                            }
                        }
                    })         
                    $(settings.before).before(t.html());  
                    root.children(settings.template+':last').attr('id', 'more_element_'+ ((variables.last++)+1))  
                })
            }            
            else {
                methods.remove()
            }
            target.children('.more_loader_spinner').css('display','none');
            if(counter < settings.amount) {
                methods.remove()
            }          
        },
        get_data : function(){
            var ile;
            lock = true;
            target.children(".more_loader_spinner").css('display','block');
            $(settings.trigger).parent().hide();
            if(typeof(arguments[0]) == 'number') {
                ile=arguments[0];
            }
            else {
                ile = settings.amount;              
            }
            
            $.post(settings.address, {
                last : variables.last, 
                amount : ile,
                mid : mid,//搜索类型
                keywords : keywords,//关键词
                cid : cid,//栏目
                title_count:settings.title_count,
                brief_count:settings.brief_count
            }, function(data){
                if (data.is_last == 0) {
                    $(settings.trigger).parent().show();
                }
                if (data.data) {
                    methods.add_elements(data.data);
                    lock = false;
                    count++;
                } else {
                    if (count == 0) {
                        $(settings.no_data).attr('style', 'display:block');
                    }
                }
            }, settings.format)
        }
    };
    $.fn.more = function(method){
        if(methods[method]) {
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        }
        else if(typeof method == 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error('Method ' + method +' does not exist!');
        }
    }    
})(jQuery)