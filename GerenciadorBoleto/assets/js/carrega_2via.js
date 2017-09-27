//Carrega dados modal 2 via.
//Prepara JQuery para execução.
$(document).ready(function(){
	//Inicia bloco de código ao clicar no elemento.
	$(".bt2via").click(function(){
		//Estabelece objeto para requisição AJAX
		var xmlhttp = new XMLHttpRequest();
		//Função para tratar retorno da requisição.
		xmlhttp.onreadystatechange = function() {
			//Caso sucesso
			if (this.readyState == 4 && this.status == 200) {
				//Captura retorno em JSON e transforma em Objeto.
				myObj = JSON.parse(this.responseText);
				//Seta campos com valor retornadoe trata máscaras.
				$("#valor").val(myObj.valor);
				execmascara();
				retiraErro($("#valor"));
				$('#vencimento').val(new Date().toDateInputValue());
				retiraErro($("#vencimento"));
			}
		};
		//Faz requisição via GET
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=carrega2via&cod=" + $(this).attr("num");
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});
//Retira mensagens de erro
function retiraErro(campo){
	var pai = $(campo).closest("div");	
	var classe = pai.attr("class");
	classe = classe.replace(/(\has-error)/g, "");
	pai.attr("class", classe);
	var erro = $(campo).next();
	erro.attr("class", "");
	erro.html("");
}
//Pega data atual
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
//Máscara valores monetários
function execmascara(){
	$("#valor").val(moeda($("#valor").val()));
}

function moeda(v){ 
v=v.replace(/\D/g,"") // permite digitar apenas numero 
v=v.replace(/(\d{1})(\d{17})$/,"$1.$2") // coloca ponto antes dos ultimos digitos 
v=v.replace(/(\d{1})(\d{13})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos 
v=v.replace(/(\d{1})(\d{10})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos 
v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 2 digitos 
v = "R$" + v; 
return v;
}