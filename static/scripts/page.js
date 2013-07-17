
  var aTag = document.getElementById('last_left').getElementsByTagName('a');
  for( var i = 0 ; i < aTag.length ; i++)
  {
  	aTag[i].onclick = function()
  	{
  		for(var j = 0 ;j < aTag.length ;j++)
  			aTag[j].setAttribute('class','');
  		this.setAttribute('class','which_page');
  	}
  }
