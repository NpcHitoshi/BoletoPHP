//Executa requisição AJAX para recarregar o Captcha.
$(document).ready(function(){
    var baseUrl = (location.protocol + '//' + location.host + '/' + "BoletoPHP/GerenciadorBoleto/")
	$.ajax({
				type: 'GET',
				url: baseUrl + 'getcaptcha.php',
				dataType: 'text',
				statusCode: {
					404: function (response) {
						console.log(404);
					},
					200: function (response) {
						console.log(response);
						$("#captcha_cnpj").attr("src", response);
					}
				}
			});
	$("#captcha").focusout(function(){
		$.ajax({
			type: 'GET',
			url: baseUrl + 'getcaptcha.php',
			dataType: 'text',
			statusCode: {
				404: function (response) {
					alert(404);
				},
				200: function (response) {
					console.log(response);
				}
			}
		});
	});
});