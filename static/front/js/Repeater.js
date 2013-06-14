// JScript 文件

/*Repeater控件*/
/*参数：selector：DOM对象*/
/*参数：jsonData：Json数据*/
/*参数：[autoDraw]：是否自动生成，默认是true，选择否需要调用draw方法来生成*/
/*参数：[showCount]：显示条目数，默认显示全部（-1）*/
/*参数：[loadFunction]：加载完成执行的方法*/
/*参数：[eachBind]：绑定每条数据触发的事件所绑定的方法，分别提供两个参数，一个是列名称，第二个是值。函数返回显示的值。*/
/*属性：selector：JQ对象*/
/*属性：jsonData：Json数据*/
/*属性：showCount：显示条目数，-1为显示全部*/
/*属性：count：记录总数*/
/*事件：loaded：加载完成执行的方法*/
/*事件：eachbind：绑定每条数据触发的事件，分别提供两个参数，一个是列名称，第二个是值。函数返回显示的值。*/
/*方法：getCode：获取组合后代码*/
/*方法：draw：显示*/
function Repeater(/*string*/selector,/*dataBox*/jsonData,/*bool*/autoDraw,/*int*/showCount,/*function*/loadFunction,/*function*/eachBind)
{
    this.selector=selector==undefined?"":$(selector);
    this.jsonData=(typeof jsonData)=="string"?eval(jsonData):jsonData;
    this.showCount=showCount==undefined?-1:parseInt(showCount);
    this.count= this.jsonData.table.length;
    this.template=(this.template==undefined?this.selector.html():this.template);
    this.loaded=loadFunction==undefined?function(){}:eval(loadFunction);
    this.cellbind=eachBind==undefined?undefined:eval(eachBind);
	this.getCode=function(){   
	        var  result=""; 
	        for(i=0;i<(this.showCount==-1?this.jsonData.table.length:this.showCount)&&i<this.jsonData.table.length;i++){
	            str=this.template;
	            for(j=0;j<this.jsonData.columnName.length;j++){
		            str=str.replace(new RegExp("#"+this.jsonData.columnName[j]+"#","g"),this.cellbind==undefined?this.jsonData.table[i][j]:this.cellbind(this.jsonData.columnName[j],this.jsonData.toClass(i)));}
                result+=str; }
            return result;} 
     this.draw=function(){ this.selector.html(this.getCode());this.loaded()}
     if(autoDraw==undefined||autoDraw){this.draw();};        
}	 

var jsc={}
Repeater.prototype.applyAll=function(){$("[jsct=repeater]").each(function(i){
    if(eval("jsc."+$(this).attr("id"))){//如果已经存在，则刷新数据
            eval("jsc."+$(this).attr("id")+".jsonData="+$(this).attr("datascource"))
            eval("jsc."+$(this).attr("id")+".draw()")}
    else{//如果不存在，在初始化一个实例
        var uc = new Repeater(this,$(this).attr("datascource"),true,$(this).attr("showcount"),$(this).attr("loaded"),$(this).attr("eachbind"))
        eval("jsc."+$(this).attr("id")+"=uc")}})}



function dataBox(/*string*/jsonString)
{
    
	var obj = eval(jsonString);
	this.table=obj.table;
	this.columnName=obj.column;
	this.type=obj.type;
	this.count=obj.count;
	this.cell=function(/*int*/rowNum,/*columnNumber/columnName*/columnName,/*[string]*/value){
	var column=(!isNaN(parseInt(columnName))?parseInt(columnName):this.getColumnIndex(columnName));
	var row=parseInt(rowNum);
	if(value==undefined||value=="")return this.table[row][column];
	else this.table[row][column]=value;
	}
	this.toClass=function(/*int*/ rowIndex){
		if(rowIndex==undefined)rowIndex=0;
		var stringbuilder="({";
		for(var i=0;i<this.columnName.length;i++){
		if(i>0)stringbuilder+=",";
		stringbuilder+=("'"+this.columnName[i]+"'")+":'"+this.table[rowIndex][i]+"'";
		}
		stringbuilder+="})";
		var object=eval(stringbuilder);
		return object;
	}	
	 this.getColumnIndex=function(/*string*/_columnName){
	for(var i=0;i<this.columnName.length;i++){
		if(this.columnName[i]==_columnName)return i;}
	}
}