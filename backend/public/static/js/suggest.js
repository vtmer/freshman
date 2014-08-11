/**
 *
 * @ye (you@example.org)
 * @date    2014-08-10 10:14:45
 * @version $Id$
 */

$(document).ready(function() {
	$('.suggestButton').click(function() {	/*$('')在里面填写所要绑定的按钮的类名*/
		var Div = $('<div class="suggest"></div>');
        var ModalContent = $('<div class="suggestList"></div>');
        var ModalHeader = $('<div class="modal-header"></div>');
		var Close = $('<button class="close">X</button>');
        var ModalTitle = $('<h3>意见反馈<h3>');
		var Formlist = $('<form action="/suggest" method=POST></form>');
		var Name = $('<input class="suggestName" type="text" value="" name="name" placeholder="姓名" required />');
		var Namewarn = $('<p class="Namewarn">*只能含有中文、字母及数字</p>');
		var Email = $('<input class="suggestEmail" type="email" placeholder="邮箱" name="email" required />');
		var Emailwarn = $('<p class="Namewarn">*格式错误</p>')
		var Content = $('<textarea class="suggestContent" placeholder="意见反馈" name="suggest" requried></textarea>');
		var Submits = $('<div><button class="Formsubmit" type="submit">提交</button></div>')
		var warn = $('<p class="warn">*意见未填写或者字数超过400字</p>')
		Div.appendTo('body');
        ModalContent.appendTo(Div);
		ModalHeader.appendTo(ModalContent);
		Close.appendTo(ModalHeader);
        ModalTitle.appendTo(ModalHeader);
		Formlist.appendTo(ModalContent);
		Name.appendTo(Formlist);
		Namewarn.appendTo(Formlist);
		Email.appendTo(Formlist);
		Emailwarn.appendTo(Formlist)
		Content.appendTo(Formlist);
		warn.appendTo(Formlist);
		Submits.appendTo(Formlist);
	})								/*创建表单*/
	$('body')						/*对响应事件进行委托*/
	.delegate('.suggestName', 'blur', function() {
		var Namevalue = $('.suggestName').val();
		var Test = /^(?:[\u4e00-\u9fa5]*\w*\s*)+$/;	/*检测姓名中是否含有非法字符*/
		var result = Test.test(Namevalue);
		if(result) {
			$(this).next().css('display', 'none');
		} else {
			$(this).next().css('display', 'inline-block');
		}
	})
	.delegate('.suggestEmail', 'blur', function() {
		var Namevalue = $(this).val();
		var Test = /^(?:[\u4e00-\u9fa5]*\s*)+$/;	/*不允许邮箱中含有中文和unicode空白符*/
		var result = Test.test(Namevalue);
		if(result) {
			$(this).next().css('display', 'inline-block');
		} else {
			$(this).next().css('display', 'none');
		}
	})
	.delegate('.suggestContent', 'blur', function() {		/*检测填写意见的字数*/
		var Value = $(this).val();
		if(Value.length == 0) $(this).next().css('display', 'inline-block');
		else if(Value.length <= 400) {
			$(this).next().css('display', 'none');
		} else {
			$(this).next().css('display', 'inline-block');
		}
	})
	.delegate('.Formsubmit', 'click', function() {
		event.stopPropagation();					/*阻止submit事件的传播*/
		var Namewarn = $('.Namewarn').css('display');
		var warn = $('.warn').css('display');
		if(Namewarn == 'none' && warn == 'none') ;
        else {
            return false;
        }
	})
	.delegate('.close', 'click', function() {
		$('.suggest').remove();					/*删除表单*/
	})

});
