var disDivHtmlInfo = {};
var buySacrificeData = null; //购买的祭品
var otherData = null; //相关属性
var currentMember = null;
var curentMaxZindex = 1;
var GlobalMemorial = { Url: "" };

$(function () {
    //mouseover info
    (function () {
        $.ajax({
            type: "get",
            url: "/MemorialHallShop/GetMemorialHallSacrifice",
            data: {
                "MemorialHallID": $("[name=MemorialHallID]").val(),
                "TypeId": $("[name=TypeId]").val(),
                "_r":Math.random()*new Date().getTime()
            },
            beforeSend: function () { },
            error: function () { },
            success: function (data) {
                disDivHtmlInfo = eval(data.SacrificeLogExtendList);
                curentMaxZindex = data.MaxZIndex;
                var MemberSacrificeLogList = eval(data.MemberSacrificeLogList);
                var IsMainMember = data.IsMainMember;
                var _len = disDivHtmlInfo.length;
                var _html = '';
                for (var i = 0; i < _len; i++) {
                    var isCurrentMemberCss = "";
                    if (!IsMainMember) {
                        for (var j = 0; j < MemberSacrificeLogList.length; j++) {
                            if (disDivHtmlInfo[i].SerialNumber == MemberSacrificeLogList[j].SerialNumber) {
                                isCurrentMemberCss = "divActive";
                                break;
                            }
                        }
                    }
                    else {
                        isCurrentMemberCss = "divActive";
                    }
                    //get file type
                    var ext = disDivHtmlInfo[i].SacrificeFilePath.slice(disDivHtmlInfo[i].SacrificeFilePath.lastIndexOf(".") + 1).toLowerCase();
                    if (ext != 'swf') {
                        _html += '<div data-zindex="' + disDivHtmlInfo[i].PositionZIndex + '" data-index="' + i + '" style="top:' + disDivHtmlInfo[i].PositionY + 'px;left:' + disDivHtmlInfo[i].PositionX + 'px;z-index:' + disDivHtmlInfo[i].PositionZIndex + '" class="disDiv ' + isCurrentMemberCss + '" data-id="' + disDivHtmlInfo[i].SerialNumber + '"><img width="' + disDivHtmlInfo[i].Width + '"  height="' + disDivHtmlInfo[i].Height + '" src="' + disDivHtmlInfo[i].SacrificeFilePath + '" /></div>';
                    } else {
                        _html += '<div data-zindex="' + disDivHtmlInfo[i].PositionZIndex + '" data-index="' + i + '" style="top:' + disDivHtmlInfo[i].PositionY + 'px;left:' + disDivHtmlInfo[i].PositionX + 'px;z-index:' + disDivHtmlInfo[i].PositionZIndex + '" class="disDiv ' + isCurrentMemberCss + '" data-id="' + disDivHtmlInfo[i].SerialNumber + '"><object width="' + disDivHtmlInfo[i].Width + '" height="' + disDivHtmlInfo[i].Height + '" sacrificeobject="sacrificeobject" data="' + disDivHtmlInfo[i].SacrificeFilePath + '" type="application/x-shockwave-flash"><param name="movie" value="' + disDivHtmlInfo[i].SacrificeFilePath + '"><param name="wmode" value="transparent"> </object></div>';
                    }
                }
                $('#SCENES').append(_html);
                divDrag($('#SCENES'), $('#SCENES .divActive'));
                divMouOverAndOut($('.disDiv'));

            }
        });
    })();

    var divMouOverAndOut = function (node) {
        node.on("mouseenter mouseleave", function (e) {
            var zindex = $(this).attr("data-zindex");
            if (!$(this).hasClass('divActive')) {
                if (e.type == 'mouseenter') {
                    var id = $(this).attr('data-index');
                    $(this).css("zIndex", parseInt(curentMaxZindex) + 1);
                    $('#toolTipHtmlInfo strong').text(disDivHtmlInfo[id].SacrificeName);
                    $('#MemberNickName').text(disDivHtmlInfo[id].MemberNickName);
                    $('#AddDateTime').text(FormatDatebox(disDivHtmlInfo[id].AddDateTime));
                    var convertData = FormatDatebox(disDivHtmlInfo[id].AddDateTime);
                    var startDate = new Date(convertData.replace(/-/g, "/"));//要计算的时间
                    var endDate = new Date(startDate.getTime() + (disDivHtmlInfo[id].EffectiveTime * 1000));
                    var curDate = new Date();
                    var effectiveDate = endDate.getTime() - curDate.getTime();
                    var restDate = GetTimeSpanDescFromSeconds(effectiveDate);
                    $('#NeedCoin').text(disDivHtmlInfo[id].NeedCoin);
                    $('#EffectiveTime').text(Math.floor(disDivHtmlInfo[id].EffectiveTime / 86400));
                    $('#RemainingTime').text(restDate);
                    //$('#toolTipHtmlInfo').remove().clone().prependTo($(this));
                    $('#toolTipHtmlInfo').css({
                        top: $(this).position().top,
                        left: $(this).position().left + $(this).width() + 2
                    }).show();
                }
                else {
                    curentMaxZindex = parseInt($(this).css("zIndex")) - 1;
                    $(this).css("zIndex", zindex);
                    $('#toolTipHtmlInfo').hide();
                }
            }
        });
    }

    // tools
    var nav_time = setTimeout(
        function () {
            $('.nav-tool ul').animate({ 'width': 0 }, 100, function () {
                $('.nav-tool .nav-btn').removeClass('open');
            });
            $('.nav-tool ul').find('span').removeClass('animated flipInY');
        }, 4000);
    $('.nav-tool .nav-btn').click(function () {
        var _self = $(this);
        if (_self.hasClass('open')) {
            $('.nav-tool ul').animate({ 'width': '0' }, 100, function () {

                _self.removeClass('open');
                $('.nav-tool ul').find('span').removeClass('animated flipInY');
            });
        } else {
            _self.addClass('open');
            $('.nav-tool ul').animate({ 'width': '80px' }, 100);
            $('.nav-tool ul').find('span').addClass('animated flipInY');
        }
    });
    $('.nav-tool').hover(function () {
        clearTimeout(nav_time);
    }, function () {
        nav_time = setTimeout(
            function () {
                $('.nav-tool .nav-btn').removeClass('open');
                $('.nav-tool ul').animate({ 'width': 0 }, 100);
                $('.nav-tool ul').find('span').removeClass('animated flipInY');
            }, 4000);
    });

    //visit
    $('.visitMeContainer').sline();


    // set
    //var _time = 0;
    //$(document).on('mousedown touchstart touchend', '#set_layer span', function (e) {
    //    var self = $(this);
    //    var type = self.attr('data-type');
    //    var id = self.parent().parent().attr('data-id');
    //    var obj = self.parent().next();
    //    var sacrificeIndex = self.parent().attr('data-index');

    //    var curDiv = self.parentsUntil('.divActive').parent();
    //    var _left = parseInt(curDiv.css('left'));
    //    var _top = parseInt(curDiv.css('top'));

    //    var realImageInfo = getRealImgInfo(obj[0]);

    //    var _w = obj.width();
    //    var _h = obj.height();
    //    var _lw = realImageInfo.width * 2;
    //    var _lh = realImageInfo.height * 2;
    //    var _sw = realImageInfo.width / 5;
    //    var _r = _w / _h;

    //    var imgInfo = { 'id': id, 'type': type, 'width': 0, 'height': 0 };

    //    switch (type) {
    //        case 'enlarge':
    //            _time = setInterval(function () {
    //                _w = _w + 1;
    //                _h = _w / _r;
    //                if (_w < _lw && _h < _lh && (_left + _w) <= 1148 && (_top + _h) <= 750) {
    //                    imgInfo.width = parseInt(_w);
    //                    imgInfo.height = parseInt(_h);
    //                    setImgAutoSize(obj, _w, _h);
    //                } else {
    //                    clearInterval(_time);
    //                }
    //            }, 10);

    //            var _flag = true;
    //            self.mousemove(function () {
    //                if (_flag) {
    //                    clearInterval(_time);
    //                    $(this).unbind('mouseup mousemove touchstart touchend');
    //                    _flag = false;
    //                    saveData($(this));
    //                }
    //            });
    //            break;
    //        case 'narrow':
    //            _time = setInterval(function () {
    //                _w = _w - 1;
    //                _h = _w / _r;
    //                if (_w > _sw) {
    //                    imgInfo.width = parseInt(_w);
    //                    imgInfo.height = parseInt(_h);
    //                    setImgAutoSize(obj, _w, _h);
    //                } else {
    //                    clearInterval(_time);
    //                }
    //            }, 10);

    //            var _flag = true;
    //            self.mousemove(function () {
    //                if (_flag) {
    //                    clearInterval(_time);
    //                    $(this).unbind('mouseup mousemove touchstart touchend');
    //                    _flag = false;
    //                    saveData($(this));
    //                }
    //            });
    //            break;
    //        case 'turn': //转移
    //            //set confirm dialog {
    //            $('#typeTurn').parent().find("div").each(function () {
    //                if ($(this).attr("id") == "typeTurn") {
    //                    $(this).show();
    //                }
    //                else {
    //                    $(this).hide();
    //                }
    //            })
    //            //$('#typeTurn').removeClass('hidden');
    //            //$('#typeDel').addClass('hidden');
    //            $('#confirm-title').text('转移【' + disDivHtmlInfo[sacrificeIndex].SacrificeName + '】');
    //            $('#confirm-dialog').modal();
    //            //}
    //            $('#okBtn').unbind().one('click', function () {
    //                var typeId=$("[name=TypeId]").val()==2?1:2; //切换墓园类型
    //                imgInfo.trunId = typeId;
    //                //turnPlace = '已' + $('#typeTurn input:checked').parent().text();
    //                $(this).addClass('disabled').text('请稍候...');
    //                TurnData(self);
    //            });
    //            break;
    //        case 'del':
    //            //set confirm dialog {
    //            $('#typeDel').parent().find("div").each(function () {
    //                if ($(this).attr("id") == "typeDel") {
    //                    $(this).show();
    //                }
    //                else {
    //                    $(this).hide();
    //                }
    //            })
    //            $('#confirm-title').text('移除【' + disDivHtmlInfo[sacrificeIndex].SacrificeName + '】');
    //            $('#offeringName').text(disDivHtmlInfo[sacrificeIndex].SacrificeName);
    //            $('#confirm-dialog').modal();
    //            $('#okBtn').unbind().bind('click', function () {
    //                $(this).addClass('disabled').text('请稍候...');
    //                delData(self);
    //            });
    //            break;
    //    }

    //    // save in database
    //    //$(this).mouseup(function (e) {
    //    //    var _self = $(this);
    //    //    _self.unbind('mouseup mousemove');
    //    //    clearInterval(_time);
    //    //    if ((type == 'enlarge' || type == 'narrow') && imgInfo.width != 0) {
    //    //        saveData(_self);
    //    //    }

    //    //});
    //    self.on('mouseup touchend', function () {
    //        var _self = $(this);
    //        _self.unbind('mouseup mousemove touchstart touchend');
    //        clearInterval(_time);
    //        if ((type == 'enlarge' || type == 'narrow') && imgInfo.width != 0) {
    //            saveData(_self);
    //        }
    //    });

    //    var delData = function (obj) //删除祭品
    //    {
    //        $.ajax({
    //            type: "post",
    //            url: "/MemorialHallShop/Del",
    //            data: imgInfo,
    //            success: function (data) {
    //                if (data.IsSuccess) {
    //                    $('#confirm-dialog').modal('hide');
    //                    $('#okBtn').removeClass('disabled').text('确定');
    //                    obj.parent().clone().appendTo('#SCENES');
    //                    obj.parent().clone().appendTo('#SCENES');
    //                    $('#toolTipHtmlInfo').clone().prependTo('#SCENES');
    //                    obj.parent().parent().remove();
    //                }
    //                else {

    //                }
    //            }

    //        })

    //    }

    //    var TurnData = function (obj) //转祭品位置
    //    {
    //        $.ajax({
    //            type: "post",
    //            url: "/MemorialHallShop/Turn",
    //            data: imgInfo,
    //            success: function (data) {
    //                if (data.IsSuccess) {
    //                    $('#confirm-dialog').modal('hide');
    //                    $('#okBtn').removeClass('disabled').text('确定');
    //                    obj.parent().clone().appendTo('#SCENES');
    //                    obj.parent().clone().appendTo('#SCENES');
    //                    $('#toolTipHtmlInfo').clone().prependTo('#SCENES');
    //                    obj.parent().parent().remove();
    //                }
    //                else {

    //                }
    //            }
    //        })
    //    }

    //    var saveData = function () { //保存祭品设置
    //        $.ajax({
    //            type: "post",
    //            url: "/MemorialHallShop/Move",
    //            data: imgInfo,
    //            beforeSend: function () {

    //            },
    //            error: function () {
    //            },
    //            success: function (data) {
    //            }
    //        });
    //    };
    //});

    $('.intro-layer').on('show.bs.modal', function (e) {
        var self = $(this);
        var btn = $(e.relatedTarget);
        var url = btn.attr('data-url');
        $.ajax({
            type: "get",
            url: url,
            success: function (data) {
                self.html(data);
            }
        })
    })

    //show model
    $('.muyuan-layer').on('show.bs.modal', function (e) {
        var self = $(e.relatedTarget);
        var tab_index = self.attr('data-tab');
        var data_tabid = self.attr('data-tabid');

        GlobalMemorial.Url = self.attr("href");
        if ($('.shop-tabs').length > 0) {
            if (data_tabid != undefined) {
                $('.shop-tabs a[href=' + data_tabid + ']').tab('show');
            }
            else {
                $('.shop-tabs li:eq(' + tab_index + ') a').tab('show');
            }
        } else {
            var inter = setInterval(
                function () {
                    if ($('.shop-tabs').length > 0) {
                        if (data_tabid != undefined) {
                            $('.shop-tabs a[href=' + data_tabid + ']').tab('show');
                        }
                        else {
                            $('.shop-tabs li:eq(' + tab_index + ') a').tab('show');
                        }
                        clearInterval(inter);
                    };
                },
                100
            );
        }
        $('html, body').animate({ scrollTop: 0 }, 1000);
    });

    //hide model
    $('.muyuan-layer').on('hidden.bs.modal', function (e) {
        $(this).find(".shop-tabs").find(".active").removeClass("active");
    })

    //show tab
    $('.muyuan-tools').on('show.bs.modal', function (e) {
        var self = $(this);
        var clickNode = $(e.relatedTarget);
        var tab_index = clickNode.attr('data-tab');
        var text = clickNode.text();
        var autoShow = function () {
            var showTabsTime = setTimeout(function () {
                if ($('.tools-tabs').size() > 0) {
                    self.find("li").find("a").each(function (i) {
                        var tabText = $(this).text();
                        if ($.trim(text) == $.trim(tabText)) {
                            $('.tools-tabs li:eq(' + i + ') a').tab('show');
                        }
                    })
                    if ($('.tools-tabs').find(".active").size() == 0) {
                        $('.tools-tabs li:eq(0) a').tab("show")
                    }
                }
                else {

                    autoShow();
                }

            }, 50)
        }
        autoShow();




        //if ($('.tools-tabs').length > 0) {
        //    $('.tools-tabs li:eq(' + tab_index + ') a').tab('show');
        //} else {
        //    var inter = setInterval(
        //        function () {


        //            if ($('.tools-tabs').length > 0) {
        //                $('.tools-tabs li:eq(' + tab_index + ') a').tab('show');
        //                clearInterval(inter);
        //            };
        //        },
        //        100
        //    );

        //}

        $('html, body').animate({ scrollTop: 0 }, 1000);
    });

    //buy counter
    $(".buy-dialog .counter").mCounter();
    $(".buy-dialog .counter .minus").click(function () {
        totalCoinCount(this);
    });
    $(".buy-dialog .counter .add").click(function () {
        totalCoinCount(this);
    });

    $(".buy-dialog .counter").children("input:text").keyup(function () {
        totalCoinCount(this);
    });
    $(".buy-dialog .counter").children("input:text").blur(function () {
        totalCoinCount(this);
    });
    var totalCoinCount = function (node, num, type) {
        var _day = $(node).parents(".text-area").find("[name=day]").val();
        var _num = $(node).parents(".text-area").find("[name=num]").val();
        var NeedCoin = $(node).parents(".text-area").find("[name=NeedCoin]").text();
        _day = _day == undefined ? 1 : _day;
        _num = _num == undefined ? 1 : _num;
        var unitPrice = parseInt(NeedCoin);
        var totalPrice = _num * _day * unitPrice;
        $(node).parents(".text-area").find("[name=TotalCoinCount]").text(totalPrice);
    }


    //购买祭品
    $('#buy_pro_btn').click(function () {
        buySacrificeData = {};
        var self = $(this);
        var curFormId = self.attr("curFormId"); //当前操作表单
        var num = $("#" + curFormId).find("[name=num]").val(); //数量
        var day = $("#" + curFormId).find("[name=day]").val(); //天数
        var totalCoin = $("#" + curFormId).find("[name=TotalCoinCount]").html();
        var memorialHallID = $("[name=MemorialHallID]").val();
        var pro_data = eval('(' + self.attr('data-info') + ')');

        CheckShopLogin(function () { //验证是否登录
            $('#typebuy').parent().find("div").each(function () {
                if ($(this).attr("id") == "typebuy") {
                    $(this).html("你确定花费<span style='color:red'>" + totalCoin + "</span>币," +
                        "购买<span style='color:red'>" + num + "</span>个【<span style='color:#f18f03'>" + pro_data.title + "</span>】祭品。").show();
                }
                else {
                    $(this).hide();
                }
            })
            $('#confirm-title').text('购买祭品');
            $('#confirm-dialog').on('show.bs.modal', function (e) {
                $('.modal-backdrop').css({ 'z-index': 100059 });
            })
            $('#confirm-dialog').on('hidden.bs.modal', function () {
                $('.modal-backdrop').css({ 'z-index': 100051 });
            });
            $('#confirm-dialog').modal();
            var BuyProduct = function () { //购买祭品
                //pro_data = eval('(' + self.attr('data-info') + ')');
                pro_data.num = num;
                pro_data.day = day;
                pro_data.memorialHallID = memorialHallID;
                $.ajax({
                    type: "post",
                    url: "/MemorialHallShop/BuyProduct",
                    data: pro_data,
                    beforeSend: function () {
                        self.addClass('disabled');
                    },
                    error: function () {
                    },
                    success: function (data) {
                        self.removeClass('disabled').hide();
                        if (data.IsSuccess) {
                            $('#confirm-dialog').modal('hide');
                            $("#buy_process").hide();
                            $('#buy_process_01').hide();
                            $('#buy_process_02').show()
                            $('#buy_process_02').find("#MaxSacrificeCount").text(data.UseObject.Data.MaxSacrificeCount);
                            $('#buy_process_02').find("#SacrificeCount").text(num);
                            //buySacrificeData = data.UseObject.Data;
                            otherData = data.UseObject.Data;
                        }
                        else {
                            self.show();
                            alert(data.Message);
                        }
                        $('#okBtn').removeClass('disabled').text('确定');
                    }
                });
            }

            $('#okBtn').unbind().bind('click', function () {
                $(this).addClass('disabled').text('请稍候...');
                BuyProduct();
            });

        })

    });

    //放进 纪念堂与墓园事件
    //$('.put-in-scenes').click(function () {
    //    putInScenes($(this));
    //});

    //添加到墓园
    $("#putInMourningHall").click(function () {
        var self = $(this);
        var data = eval('(' + $(this).attr('data-info') + ')');
        var text = self.text();
        var curFormId = self.attr("curFormId"); //当前操作表单
        var num = $("#" + curFormId).find("[name=num]").val(); //数量
        var day = $("#" + curFormId).find("[name=day]").val(); //天数
        var memorialHallID = $("[name=MemorialHallID]").val();
        var typeId = $("[name=TypeId]").val();//当前纪念馆墓园类型编号
        var maxSacrificeCount = otherData.MaxSacrificeCount;
        data.num = num;
        data.day = day;
        data.memorialHallID = memorialHallID;
        data.maxSacrificeCount = maxSacrificeCount;
        data.typeId = 1; //墓园类别编号
        $.ajax({
            type: "post",
            url: "/MemorialHallShop/AddSacrificeLog",
            beforeSend: function () {
                self.addClass('disabled').text("正在处理...");
            },
            data: data,
            success: function (data) {
                if (data.IsSuccess) {
                    buySacrificeData = data.UseObject.Data;
                    if (typeId == 1) {
                        putInScenes(self);
                    }
                    else {
                        $('.buy-dialog').modal('hide');
                        $('.muyuan-layer').modal('hide');
                        showMsg("添加到灵堂成功！", 'ok');
                    }
                }
                else {
                    alert(data.Message);
                }
                self.removeClass('disabled').text(text);
            }

        })

    })

    //添加到纪念堂
    $("#putInCemetery").click(function () {
        var self = $(this);
        var data = eval('(' + $(this).attr('data-info') + ')');
        var text = self.text();
        var curFormId = self.attr("curFormId"); //当前操作表单
        var num = $("#" + curFormId).find("[name=num]").val(); //数量
        var day = $("#" + curFormId).find("[name=day]").val(); //天数
        var memorialHallID = $("[name=MemorialHallID]").val();
        var typeId = $("[name=TypeId]").val();//当前纪念馆墓园类型编号
        var maxSacrificeCount = otherData.MaxSacrificeCount;
        data.num = num;
        data.day = day;
        data.memorialHallID = memorialHallID;
        data.maxSacrificeCount = maxSacrificeCount;
        data.typeId = 2;
        $.ajax({
            type: "post",
            url: "/MemorialHallShop/AddSacrificeLog",
            beforeSend: function () {
                self.addClass('disabled').text("正在处理...");
            },
            data: data,
            success: function (data) {
                if (data.IsSuccess) {
                    buySacrificeData = data.UseObject.Data;
                    if (typeId == 2) {
                        putInScenes(self);
                    }
                    else {
                        $('.buy-dialog').modal('hide');
                        $('.muyuan-layer').modal('hide');
                        showMsg("添加到墓园成功！", 'ok');
                    }

                }
                else {
                    alert(data.Message);
                }
                self.removeClass('disabled').text(text);
            }

        })

    })

});

var putInScenes = function (obj) {
    var data = eval('(' + obj.attr('data-info') + ')');
    var MemorialHallID = $("[name=MemorialHallID]").val();

    $('<div id="_MASK" />').css({
        'opacity': .8,
        'background-color': '#000',
        'width': '100%',
        'height': '100%',
        'position': 'absolute',
        'top': 0,
        'left': 0,
        'z-index': curentMaxZindex
    }).appendTo('#SCENES');

    for (var i = 0; i < buySacrificeData.length; i++) {
        curentMaxZindex = buySacrificeData[i].PositionZIndex;
        var curDatalength = disDivHtmlInfo.length;
        var _effectiveTime = buySacrificeData[i].EffectiveTime;
        //var ofsetLeft = 0;
        var info = {
            "SacrificeName": data.title,
            "SacrificeFilePath": data.src,
            "MemberNickName": otherData.NickName,
            "SacrificeLogID": buySacrificeData[i].SacrificeLogID,
            "MemorialHallID": MemorialHallID,
            "Width": buySacrificeData[i].Width,
            "Height": buySacrificeData[i].Height,
            "PositionX": buySacrificeData[i].PositionX,
            "PositionY": buySacrificeData[i].PositionY,
            "PositionZIndex": buySacrificeData[i].PositionZIndex,
            "NeedCoin": buySacrificeData[i].NeedCoin,
            "EffectiveTime": buySacrificeData[i].EffectiveTime,
            "AddDateTime": buySacrificeData[i].AddDateTime
        };

        if (data.src.indexOf(".swf") > 0) {
            //ofsetLeft = i * (data.width + 5);
            _html = '<div data-zindex="' + buySacrificeData[i].PositionZIndex + '" data-index="' + curDatalength + '" style="top:' + buySacrificeData[i].PositionY + 'px;left:' + buySacrificeData[i].PositionX + 'px;;z-index:' + buySacrificeData[i].PositionZIndex + '" class="disDiv divActive" data-id="' + buySacrificeData[i].SerialNumber + '"><object width="' + buySacrificeData[i].Width + '" height="' + buySacrificeData[i].Height + '" sacrificeobject="sacrificeobject" data="' + data.src + '" type="application/x-shockwave-flash"><param name="movie" value="' + data.src + '"><param name="wmode" value="transparent"> </object></div>';
            $('#SCENES').append(_html);
            divDrag($('#SCENES'), $('#SCENES').children('.divActive').last());
            disDivHtmlInfo.push(info);
        } else {
            //ofsetLeft = i * (data.width + 5);
            _html = '<div data-zindex="' + buySacrificeData[i].PositionZIndex + '" data-index="' + curDatalength + '" style="top:' + buySacrificeData[i].PositionY + 'px;left:' + buySacrificeData[i].PositionX + 'px;z-index:' + buySacrificeData[i].PositionZIndex + '" class="disDiv divActive" data-id="' + buySacrificeData[i].SerialNumber + '"><img width="' + buySacrificeData[i].Width + '" height="' + buySacrificeData[i].Height + '" src="' + data.src + '" /></div>';
            $('#SCENES').append(_html);
            divDrag($('#SCENES'), $('#SCENES').children('.divActive').last());
            disDivHtmlInfo.push(info);
        }
        curDatalength = curDatalength + 1;
    }


    $('.buy-dialog').modal('hide');
    $('.muyuan-layer').modal('hide');
}


/*
 *  设置场景
 *  &scenes 场景
 *  &obj 拖动层
 *  &type
 */
var divDrag = function (scenes, obj, type) {
    var isDrag = false;
    var $div = scenes;
    obj.click(function () {
        //curentMaxZindex = parseInt(curentMaxZindex) + 1;
        //$(this).css('zIndex',curentMaxZindex);
    }).drag("start", function () {
        isDrag = true;
        curentMaxZindex = parseInt(curentMaxZindex) + 1;
        $(this).css('zIndex', curentMaxZindex);
        $(this).attr("data-zindex", curentMaxZindex);
        $('#_MASK').remove();
    }).drag("end", function (ev, dd) {
        $('#toolTipHtmlInfo').removeAttr('style');
        var cd = {};
        cd.id = $(this).attr('data-id');
        cd.left = $(this).position().left;
        cd.top = $(this).position().top;
        cd.zindex = $(this).css('z-index');
        !type ? saveXYZ(cd) : false;
    }).drag(function (ev, dd) {
        $('#toolTipHtmlInfo').hide();

        _halfX = parseInt($(this).outerWidth() / 2);
        _halfY = parseInt($(this).outerHeight() / 2);
        _tempY = $div.outerHeight() - _halfY;
        _tempX = $div.outerWidth() - _halfX;

        dd.offsetY = dd.offsetY < _tempY ? dd.offsetY : _tempY;
        dd.offsetX = dd.offsetX < _tempX ? dd.offsetX : _tempX;
        dd.offsetY = dd.offsetY <= -_halfY ? -_halfY : dd.offsetY;
        dd.offsetX = dd.offsetX <= -_halfX ? -_halfX : dd.offsetX;

        $(this).css({
            top: dd.offsetY,
            left: dd.offsetX
        });
    }, { relative: true, not: 'span' });


    if (!type) {
        obj.on("mouseenter mouseleave touchstart touchend", function (e) {
            var zindex = $(this).attr("data-zindex");
            e.stopPropagation();
            e.preventDefault();
            if (e.type == 'mouseenter' || e.type == 'touchstart') {
                var id = $(this).attr("data-index");
                $(this).css("zIndex", parseInt(curentMaxZindex) + 1);
                // $('#set_layer').attr('data-index', id).remove().clone().prependTo($(this));
                showTools($(this), id);
                $('#toolTipHtmlInfo strong').text(disDivHtmlInfo[id].SacrificeName);
                $('#MemberNickName').text(disDivHtmlInfo[id].MemberNickName);
                $('#AddDateTime').text(FormatDatebox(disDivHtmlInfo[id].AddDateTime));
                var convertData = FormatDatebox(disDivHtmlInfo[id].AddDateTime);
                var startDate = new Date(convertData.replace(/-/g, "/"));//要计算的时间
                var endDate = new Date(startDate.getTime() + (disDivHtmlInfo[id].EffectiveTime * 1000));
                var curDate = new Date();
                var effectiveDate = endDate.getTime() - curDate.getTime();
                var restDate = GetTimeSpanDescFromSeconds(effectiveDate);
                $('#NeedCoin').text(disDivHtmlInfo[id].NeedCoin);
                $('#EffectiveTime').text(Math.floor(disDivHtmlInfo[id].EffectiveTime / 86400));
                $('#RemainingTime').text(restDate);
                //$('#toolTipHtmlInfo').remove().clone().prependTo($(this));

                $('#toolTipHtmlInfo').css({
                    top: $(this).position().top,
                    left: $(this).position().left + $(this).width() + 2
                }).show();
            }
            else {
                if (!isDrag) {
                    curentMaxZindex = parseInt($(this).css("zIndex")) - 1;
                }
                $(this).css("zIndex", zindex);
                $('#toolTipHtmlInfo').hide();
            }
        });
    }
};


var showTools = function (obj, zindex) {
    $('#set_layer').attr('data-index', zindex).remove().clone().prependTo(obj);
    var _time = 0;
    $('#set_layer span').on('mousedown touchstart touchend', function (event) {
        event.stopPropagation();
        event.preventDefault();
        var self = $(this);
        var type = self.attr('data-type');
        var id = self.parent().parent().attr('data-id');
        var sacrificeIndex = self.parent().attr('data-index');
        var obj = self.parent().next();

        var curDiv = self.parentsUntil('.divActive').parent();
        var _left = parseInt(curDiv.css('left'));
        var _top = parseInt(curDiv.css('top'));

        var realImageInfo = getRealImgInfo(obj[0]);

        var _w = obj.width();
        var _h = obj.height();
        var _lw = realImageInfo.width * 2;
        var _lh = realImageInfo.height * 2;
        var _sw = realImageInfo.width / 5;
        var _r = _w / _h;

        var imgInfo = { 'id': id, 'type': type, 'width': 0, 'height': 0, 'trunId': 0 };
        var turnPlace = '';
        clearInterval(_time);
        switch (type) {
            case 'enlarge':
                _time = setInterval(function () {
                    _w = _w + 1;
                    _h = _w / _r;
                    if (_w < _lw && _h < _lh && (_left + _w) <= 1148 && (_top + _h) <= 750) {
                        imgInfo.width = parseInt(_w);
                        imgInfo.height = parseInt(_h);
                        setImgAutoSize(obj, _w, _h);
                    } else {
                        clearInterval(_time);
                    }
                }, 10);

                var _flag = true;
                self.on('mousemove touchmove', function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    if (_flag) {
                        clearInterval(_time);
                        $(this).unbind('mouseup mousemove touchmove');
                        _flag = false;
                        saveData($(this));
                    }
                });
                break;
            case 'narrow':
                _time = setInterval(function () {
                    _w = _w - 1;
                    _h = _w / _r;
                    if (_w > _sw) {
                        imgInfo.width = parseInt(_w);
                        imgInfo.height = parseInt(_h);
                        setImgAutoSize(obj, _w, _h);
                    } else {
                        clearInterval(_time);
                    }
                }, 10);

                var _flag = true;
                self.on('mousemove touchmove', function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    if (_flag) {
                        clearInterval(_time);
                        $(this).unbind('mouseup mousemove touchmove');
                        _flag = false;
                        saveData($(this));
                    }
                });
                break;
            case 'turn':
                //set confirm dialog {
                $('#typeTurn').parent().find("div").each(function () {
                    if ($(this).attr("id") == "typeTurn") {
                        $(this).show();
                    }
                    else {
                        $(this).hide();
                    }
                })
                $('#confirm-title').text('转移【' + disDivHtmlInfo[sacrificeIndex].SacrificeName + '】');
                $('#confirm-dialog').modal();
                $('#okBtn').unbind();
                //}
                $('#okBtn').one('click', function () {

                    var typeId = $("[name=TypeId]").val() == 2 ? 1 : 2; //切换墓园类型
                    imgInfo.trunId = typeId;
                    //turnPlace = '已' + $('#typeTurn input:checked').parent().text();
                    $(this).addClass('disabled').text('请稍候...');
                    TurnData(self);
                });
                break;
            case 'del':
                //set confirm dialog {
                $('#typeDel').parent().find("div").each(function () {
                    if ($(this).attr("id") == "typeDel") {
                        $(this).show();
                    }
                    else {
                        $(this).hide();
                    }
                })
                $('#confirm-title').text('移除【' + disDivHtmlInfo[sacrificeIndex].SacrificeName + '】');
                $('#offeringName').text(disDivHtmlInfo[sacrificeIndex].SacrificeName);
                $('#confirm-dialog').modal();
                $('#okBtn').unbind();
                //}
                $('#okBtn').one('click', function () {
                    $(this).addClass('disabled').text('请稍候...');
                    delData(self);
                });
                break;
        }

        // save in database
        self.on('mouseup touchend', function (ent) {
            ent.stopPropagation();
            ent.preventDefault();
            var _self = $(this);
            _self.unbind('mouseup mousemove touchmove touchend');

            if ((type == 'enlarge' || type == 'narrow') && imgInfo.width != 0) {
                saveData(_self);
            }
            clearInterval(_time);
        });

        var delData = function (obj) //删除祭品
        {
            $.ajax({
                type: "post",
                url: "/MemorialHallShop/Del",
                data: imgInfo,
                success: function (data) {
                    if (data.IsSuccess) {
                        $('#confirm-dialog').modal('hide');
                        $('#okBtn').removeClass('disabled').text('确定');
                        obj.parent().clone().appendTo('#SCENES');
                        obj.parent().clone().appendTo('#SCENES');
                        $('#toolTipHtmlInfo').clone().prependTo('#SCENES');
                        obj.parent().parent().remove();
                    }
                    else {

                    }
                }
            })
        }

        var TurnData = function (obj) //转祭品位置
        {
            console.log(obj);
            $.ajax({
                type: "post",
                url: "/MemorialHallShop/Turn",
                data: imgInfo,
                success: function (data) {
                    if (data.IsSuccess) {
                        $('#confirm-dialog').modal('hide');
                        $('#okBtn').removeClass('disabled').text('确定');
                        obj.parent().clone().appendTo('#SCENES');
                        obj.parent().clone().appendTo('#SCENES');
                        $('#toolTipHtmlInfo').clone().prependTo('#SCENES');
                        obj.parent().parent().remove();
                    }
                    else {

                    }
                }
            })
        }
        var saveData = function () { //保存祭品设置
            $.ajax({
                type: "post",
                url: "/MemorialHallShop/Move",
                data: imgInfo,
                beforeSend: function () {

                },
                error: function () {
                },
                success: function (data) {
                }
            });
        };
    });

}
var getRealImgInfo = function (img) {
    var imgInfo = { width: 300, height: 300 };
    if (img.src) {
        var image = new Image();
        image.src = img.src;
        imgInfo.width = image.width;
        imgInfo.height = image.height;
    }
    return imgInfo;
};

var setImgAutoSize = function (obj, w, h) {
    obj.attr('width', w);
    obj.attr('height', h);
}

//save XYZ in database
var saveXYZ = function (jsonData) {
    $.ajax({
        type: "post",
        url: "/MemorialHallShop/Move",
        data: jsonData,
        beforeSend: function () {
        },
        error: function () {
        },
        success: function (data) {
        }
    });
};

//切换验证码
var verifyCode = function (node) {
    $(node)[0].src = "/Shared/VerifyCode?time=" + (new Date()).getTime();
}

function GetTimeSpanDescFromSeconds(value) {
    //计算出相差天数
    var days = Math.floor(value / (24 * 3600 * 1000));
    var leave1 = value % (24 * 3600 * 1000);
    var hours = Math.floor(leave1 / (3600 * 1000));
    var leave2 = leave1 % (3600 * 1000);
    var minutes = Math.floor(leave2 / (60 * 1000));
    var leave3 = leave2 % (60 * 1000);
    var seconds = Math.round(leave3 / 1000);

    var text = '';

    if (days > 0)
        text += days + "天";
    if (hours > 0)
        text += hours + "个小时";
    if (minutes > 0)
        text += minutes + "分钟";
    if (seconds > 0)
        text += seconds + "秒";

    return text;
}

function curentTime() {
    var now = new Date();
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
    var hh = now.getHours();            //时
    var mm = now.getMinutes();          //分
    var clock = year + "-";
    if (month < 10)
        clock += "0";

    clock += month + "-";
    if (day < 10)
        clock += "0";

    clock += day + " ";
    if (hh < 10)
        clock += "0";

    clock += hh + ":";
    if (mm < 10) clock += '0';
    clock += mm;
    return (clock);
}

Date.prototype.Format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, // month
        "d+": this.getDate(), // day
        "h+": this.getHours(), // hour
        "m+": this.getMinutes(), // minute
        "s+": this.getSeconds(), // second
        "q+": Math.floor((this.getMonth() + 3) / 3), // quarter
        "S": this.getMilliseconds()
        // millisecond
    }
    if (/(y+)/.test(format))
        format = format.replace(RegExp.$1, (this.getFullYear() + "")
            .substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
    return format;
}
//日期格式化
function FormatDatebox(value) {
    var dt;
    if (value != undefined) {
        dt = new Date(parseInt(value.replace("/Date(", "").replace(")/", ""), 10));
        return dt.Format("yyyy-MM-dd hh:mm:ss");
    }
    else {
        return '';
    }
}