window.selectFocus = function(that) { 
	$(that).attr("size", 5); 
	$("#quantityinput").css("z-index", "-1"); 
	$(that).css("height", "150px"); 
}; 
window.selectClick = function(that) { 
	$("#quantityinput").css("z-index", "1"); 
	$("#quantity").css("height", "26px");
	$(that).parent().removeAttr("size"); 
	$(that).parent().blur(); 
	$(that).parent().children("[selected='selected']").removeAttr("selected"); 
	$(that).attr("selected", ""); 
};