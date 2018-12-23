$(function() {

    $("#reg-btn").click(function(){
		$(".login-step-1").slideUp(function(){
			$(".login-step-2-reg").slideDown();
		});
	});

	$("#log-btn").click(function(){
		$(".login-step-1").slideUp(function(){
			$(".login-step-2-log").slideDown();
		});
	});

	$(".login-back").click(function(){
		$(this).parent().parent().slideUp(function(){
			$(".login-step-1").slideDown();
		});
	});

});
