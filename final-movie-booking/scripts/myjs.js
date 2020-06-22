$(function(){ 

	$(".popup").hide();//Hide on load

	$("#register").on("click", function(){
		// $(".popup").toggle(500);
		$(".popup-register").show();
	});
	$("#login").on("click", function(){
		$(".popup-login").show();
	});
	$(".close").on("click", function(){
		$(".popup").hide();
	});	
});