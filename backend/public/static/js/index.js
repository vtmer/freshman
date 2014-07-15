$(document).ready(function(){

    function init() {
            var  aUl = $(".nav li");
            index = 0; /*设置初始的值*/
            timer = play = null;
            controlIndex = 1;
            navHover(aUl,"static/images/underline.jpg");
            autoPlay();
            Gallery();
            chooseCompus();
            photoHover();
            getHeight();

            return 0;



    }

    function navHover (target,Tsrc) {
        oImg = document.createElement("img");

        /*appendChild()是DOM的方法，所以appendChild($(""))是会失效的*/

        $(".nav").append(oImg);
        oImg.src = Tsrc;
        oImg.style.top = "27px";
        oImg.style.position = "absolute";
        oImg.style.display = "block";

        for (var i = 0 ; i < target.length; i++) {
            target.eq(i).attr("index",i);
            oImg.style.left = $(".default").attr("index")*86+37+"px";
            target.eq(i).mouseenter(function () {
                oImg.style.position = "absolute";
                oImg.style.display = "block";
                oLeft = $(this).attr("index")*86+37+"px";
                $(oImg).animate({left:oLeft},
                                {
                                    duration: 500,
                                    queue: false
                                });

            });
        }

        $(".nav").mouseleave(function (event) {
               var event = event || window.event;
                $(oImg).animate({"left":$(".default").attr("index")*86+37+"px"},
                                {
                                    duration: 500,
                                    queue: false
                                });
                oImg.style.display = "block";
            });
    }



    /*下拉菜单*/

    function chooseCompus () {

        var sUl = $(".special_down");
        var sDown = $(".special_a");

        sDown.mouseover(function () {
            sUl.css("display","block");
            navParent = $(".nav");
            navParent.get(0).removeChild(oImg);

        });
        sDown.mouseout(function () {
            sUl.css("display","none");
            navHover($(".nav"),"static/images/underline.jpg");
        });
        sUl.mouseover(function () {
            sUl.css("display","block");
            navParent = $(".nav");
            navParent.get(0).removeChild(oImg);
        });
        sUl.mouseout(function () {
            sUl.css("display","none");
            navHover($(".nav"),"static/images/underline.jpg");
        });

    }


    /*背景图片功能*/

    function Gallery () {
        $oDot = $(".dot");
        $oBac = $(".gallery li");
        $($oBac[0]).addClass("current");
        $($oBac[1]).addClass("next");

        for (var i = 0; i < $oDot.length; i++)
        {
            $($oDot[i]).attr("index",i);
            $($oBac[i]).attr("index",i);

        }

        for(var i = 0; i < $oDot.length; i++)
        {
            $($oDot[i]).mouseover(function () {

                index = $(this).attr("index");
                clearInterval(play);

                $($oDot[$(".current").attr("index")]).attr("src","static/images/dot.png");
                $($oDot[$(".next").attr("index")]).attr("src","static/images/dot.png");
                $(this).attr("src","static/images/dot_red.png");
                $(".current").stop();


                $(".current").css("display","block");
                $(".next").removeClass("next");
                $($oBac[$(this).attr("index")]).addClass("next");

                show();

            });

            $($oDot[i]).mouseout(function () {

                autoPlay();

            });
        }

    }

    /*自动播放*/

    function autoPlay ()
    {
        play = setInterval(function () {

            show();
            $($oDot[$(".current").attr("index")]).attr("src","static/images/dot.png");
            $($oDot[$(".next").attr("index")]).attr("src","static/images/dot_red.png");
            index++;
            if (index >2) {
                 index  = 0 ;
            }

        },4000);


    }

    function show () {

        var $oBac = $(".gallery li");

        $(".current").fadeOut("slow",function(){

            $(".current").css("display","block").removeClass("current");
            $($(".next")).addClass("current").removeClass("next");

            if($(".current").attr("index") == 2) {
                $($oBac[0]).addClass("next");
            }
            else {
                $(".current").next().addClass("next");
            }

        });


    }


    function photoHover () {
        var grayLength = $(".gray_pic").length;
        for(var i = 0; i < grayLength; i++) {
            $(".gray_pic").eq(i).mouseenter(function(){
                $(this).removeClass("gray_pic");

            });
            $(".gray_pic").eq(i).mouseleave(function(){
                $(this).addClass("gray_pic");
            });
        }
    }



    function getHeight () {
        var headHeight = $(".mainmenu").offset().top - $(".logo").height()-50;
        $("#goBottom").click(function () {
            var i = 0;
            goBottom = setInterval (function(){
                $(window).scrollTop(i+=100);
                if (i > headHeight) {
                    clearInterval(goBottom);
                };
            },40)
            $(".logo").css("background-color","#d43434");
            $(".logoWrapper").css("background-image","url(static/images/logo_down.png)");
            $(".nav a").css("color","white");
            $(".special_a").css("background-image","url(static/images/nav_position.jpg)");
             $(oImg).css("visibility","hidden") ;
                        for(var i = 0; i < $(".nav a").length-3; i++) {
                                $(".nav a").eq(i).mouseenter(function() {

                                   $(this).css("background-color","white");
                                   $(this).css("color","#da5d5d");
                                });
                                $(".nav a").eq(i).mouseleave(function() {

                                   $(this).css("background-color","");
                                   $(this).css("color","white");
                                });
                        }
                         for(var i = $(".nav a").length-2; i < $(".nav a").length; i++) {
                                $(".nav a").eq(i).mouseenter(function() {

                                   $(this).css("background-color","white");
                                   $(this).css("color","red");
                                });
                                $(".nav a").eq(i).mouseleave(function() {

                                   $(this).css("background-color","");
                                   $(this).css("color","black");
                                });
                            }


        });

    }

    init();
});
		$(window).scroll(function(event) {
            if($("body").scrollTop() == 0) {
                $(".logo").removeClass("fixed");
            } else {       
                 $(".logo").addClass("fixed");                       
            };    
        });
