window.selectFocus = function(that,id) { 
	$(that).attr("size", 5); 
	$("#quantityinput"+id).css("z-index", "-1"); 
	$("#quantity"+id).css("height", "80px"); 
}; 
window.selectClick = function(that,id) { 
	$("#quantityinput"+id).css("z-index", "1"); 
	$("#quantity"+id).css("height", "26px");
	$(that).parent().removeAttr("size"); 
	$(that).parent().blur(); 
	$(that).parent().children("[selected='selected']").removeAttr("selected"); 
	$(that).attr("selected", ""); 
};