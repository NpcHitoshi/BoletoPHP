$(document).ready(function(){
	$("#captcha").focusout(function(){
		event.preventDefault();
		var ccnpj = $("#cnpj").val();
		var ccaptcha_cnpj = $("#captcha").val();
		var form_url = "/processa.php";
		var form_method = "_POST";
		$.ajax({
			url: window.location.href+"/processa.php",
			type: "post",
			data: { 'cnpj': ccnpj, 'captcha_cnpj': ccaptcha_cnpj, }
		});
		$.post(window.location.href+"/processa.php", function(data) {
			var_dump(data);

		});
	});
});


