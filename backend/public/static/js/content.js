$(document).ready(function(){

    function init() {
            var  aUl = $(".nav li");
            index = 0; /*设置初始的值*/
            navHover(aUl,"images/underline.jpg");
            chooseCompus();
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
            navHover($(".nav"),"images/underline.jpg");
        });
        sUl.mouseover(function () {
            sUl.css("display","block");
            navParent = $(".nav");
            navParent.get(0).removeChild(oImg);
        });
        sUl.mouseout(function () {
            sUl.css("display","none");
            navHover($(".nav"),"images/underline.jpg");
        });

    }

    init();

});