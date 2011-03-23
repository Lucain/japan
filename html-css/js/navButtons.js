function clearText(thefield){
	if (thefield.defaultValue==thefield.value)
		thefield.value = "";
}
$(document).ready(function() {
	$(".fb").fancybox({
		modal : true,
		type: 'iframe',
		overlayOpacity : 0.9,
		overlayColor : '#000000',
		width : 680,
		height : 640,
		autoScale : false,
		margin : 0
	});
	
	$(".login-link").fancybox({
		modal : true,
		type: 'iframe',
		overlayOpacity : 0.9,
		overlayColor : '#000000',
		width : 410,
		height : 270,
		autoScale : false,
		scrolling : 'no'
	});
	$("a.contact").fancybox({
		type: 'iframe',
		overlayOpacity : 0.9,
		overlayColor : '#000000',
		width : 500,
		height : 300
	});
});