$(document).ready(function() {
	campusChange();
	scrollCreate();
});
function campusChange() {
	$('.campus-list .active a').click(function(event) {
		var e = window.event || event;
		var list = $(this).parent().parent();
		var overflow = list.css("overflow");
		overflow = overflow == "hidden" ? "visible":"hidden";
		list.css({overflow:overflow});
		return false;
	});
}
var page = 1;
var requestTime = 1;
var Top = $('.footer');
var itemHeight = $('.news-item');
var loading = $('.loading');
function scrollCreate() {
	console.log("测试");
	console.log(loading[0]);
	if(loading[0] == undefined) return;
	$(document).scroll(function(){
		var Topheight = Top.offset().top;
		var itemH = itemHeight.eq(0).height();
		var target = Topheight - itemH;
		var scrollTop = $(window).scrollTop()+$(window).height();
		if(scrollTop > target && requestTime == 1) {
			loading.css({display:'block'}).text("正在加载中..");
			requestTime = 0;
			page++;
			var hostname = window.location.href;
			var reg = /category/;
			var urlname = hostname.replace(reg,"m-category");
			var url = urlname + '?page=' + page;
			console.log(url);
			$.ajax( {
			    url:url,// 跳转到 action
			    type:'get',
			    cache:false,
			    dataType:'json',
			    success:function(data) {
    				var Datas = data;
    				var point = $('.news-list');
    				if(Datas.data.length == 0) {
    					loading.text("无更多内容");
    				} else {
		       			for(var i = 0; i < Datas.data.length ; i++) {
                            var itemClone = $('.news-item').eq(0).clone();
							var newsTitle = itemClone.find('.news-item-title').find('a');
							newsTitle.text(Datas.data[i].title);
							var host = window.location.origin;
							var href = host +"/article/"+Datas.data[i].cid+'/'+Datas.data[i].id;
							newsTitle.attr({href:href});
							var newsBody = itemClone.find('.news-item-main').find('p').find('a');
							newsBody.text(Datas.data[i].desc);
							newsBody.attr({href:href});
							var info = itemClone.find('.news-item-main').find('span');
							info.eq(0).text(Datas.data[i].source);
							var times = Datas.data[i].created_at.date.split(" ");
							info.eq(1).text(times[0]);
							info.eq(2).text(times[1]);
							point.append(itemClone);
						}
						loading.css({display:"none"});
						requestTime = 1;
    				}

	          	},
				error : function() {
					loading.text("加载失败，请重新刷新");
					requestTime = 1;
					page--;
				}
			});
		}
	})
}
