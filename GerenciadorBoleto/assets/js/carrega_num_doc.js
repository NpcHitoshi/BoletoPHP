//Pega número do documento de novo boleto.
//Prepara JQuery para execução.
$(document).ready(function(){
	//Aciona bloco quando combo é aberto ou muda de valor.
	$("#cliente").on('select2:opening change', function(){
		// Instância objeto para requisição.
		var xmlhttp = new XMLHttpRequest();
		//Trata retorno
		xmlhttp.onreadystatechange = function() {
			//Caso sucesso.
			if (this.readyState == 4 && this.status == 200) {
				//Trata retorno JSON em um Objeto e seta o campo com o valor.
				myObj = JSON.parse(this.responseText);
				$("#numDoc").val(myObj.num);
			}
		};
		//Executa requisição AJAX
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=carregaNumDocumento&cod=" + $(this).val();
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});
