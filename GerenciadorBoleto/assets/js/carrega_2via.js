$(document).ready(function(){
	$(".bt2via").click(function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				$("#valor").val(myObj.valor);
				$("#vencimento").val(myObj.dataAtual);
			}
		};
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=carrega2via&cod=" + $(this).attr("num");
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});