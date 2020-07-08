window.selectFocus = function(that) { 
	$(that).attr("size", 5); 
}; 
window.selectClick = function(that) { 
	$(that).parent().removeAttr("size"); 
	$(that).parent().blur(); 
	$(that).parent().children("[selected='selected']").removeAttr("selected"); 
	$(that).attr("selected", ""); 
};