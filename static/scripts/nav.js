
  var aTag = document.getElementById('nav_ul').getElementsByTagName('a');
  for( var i = 0 ; i < aTag.length ; i++)
  {
  	aTag[i].onclick = function()
  	{
  		for(var j = 0 ;j < aTag.length ;j++)
  			aTag[j].setAttribute('id','');
  		this.setAttribute('id','choose');
  	}
  }
