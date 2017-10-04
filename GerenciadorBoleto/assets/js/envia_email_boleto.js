//Envia e-mail com após novo boleto.
//Prepara JQuery para execução.
$(document).ready(function(){
	//Executa bloco ao clicar
	$(".btn-email").click(function(){
		//Instância objetos para requisição.
		var xmlhttp = new XMLHttpRequest();
		var xmlhttp1 = new XMLHttpRequest();
		//Trata retorno requisição 2.
		xmlhttp1.onreadystatechange = function() {
			//Caso sucesso redireciona a tela.
			if (this.readyState == 4 && this.status == 200) {
				window.location.href = "http://" + window.location.hostname + ":" + window.location.port + "/BoletoPHP/GerenciadorBoleto/boletos.php";
			}
		};
		//Trata retorno requisição 1.
		xmlhttp.onreadystatechange = function() {
			//Caso sucesso faz requisição AJAX para segunda etapa do e-mail.
			if (this.readyState == 4 && this.status == 200) {
				var url1 = "/BoletoPHP/GerenciadorBoleto/email.php?cod=" + cod;
				xmlhttp1.open("GET", url1 , true);
				xmlhttp1.send();
			}
		};
		//Executa requisição AJAX para primeira etapa do e-mail.
                var cod = $(this).attr("banco");
		var url = $(this).attr("link1");
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});