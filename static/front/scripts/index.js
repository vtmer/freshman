(function($){
	$(function(){
		/*图片库切换
		----------------------------------*/ 
		var $gallery = $('#gallery'),
			$prev = $('#prev-img'),
			$next = $('#next-img'),
			$imgBlock = $('#img-block'),
			$img = $imgBlock.find('img'),
			$descBlock = $('#img-description');
		$img.eq(0).css({'z-index':100});
		var len = $img.length;
		var count = len*10;
		function imgSwitch($topImg,$bottomImg){//处理图片切换
			var desc = $bottomImg.attr('alt');
			$bottomImg.css({'z-index':10});
			$topImg.fadeOut(function(){
				$topImg.css({
					'display':'block',
					'z-index':0
				});
				$bottomImg.css({'z-index':100});
				$descBlock.text(desc);
			});
		}
		$prev.on('click',function(){
			if($img.is(':animated'))return false;//如果处于动画状态，则不执行
			var $bottomImg = $img.eq((count-1)%4);
			var $topImg = $img.eq(count%4);
			imgSwitch($topImg,$bottomImg);
			count -= 1;
			if(!count){
				count = len*10;//如果count为0
			}
			return false;
		});
		$next.on('click',function(){
			if($img.is(':animated'))return false;
			var $bottomImg = $img.eq((count+1)%4);
			var $topImg = $img.eq(count%4);
			imgSwitch($topImg,$bottomImg);
			count += 1;
			return false;
		});
	});
}(jQuery));