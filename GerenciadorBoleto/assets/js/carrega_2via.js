$(document).ready(function(){
	$(".bt2via").click(function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				$("#valor").val(myObj.valor);
				retiraErro($("#valor"));
				$("#vencimento").val(myObj.dataAtual);
				retiraErro($("#vencimento"));
			}
		};
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=carrega2via&cod=" + $(this).attr("num");
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});

function retiraErro(campo){
	var pai = $(campo).closest("div");	
	var classe = pai.attr("class");
	classe = classe.replace(/(\has-error)/g, "");
	pai.attr("class", classe);
	var erro = $(campo).next();
	erro.attr("class", "");
	erro.html("");
}