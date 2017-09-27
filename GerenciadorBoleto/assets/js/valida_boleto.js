//Validações Novo Boleto
$(document).ready(function(){ 
	//Validações ao tentar Submit
	$("form").submit(function(e){
		//Valida Numero Documento
		if(($("#numDoc")).val().length < 1){
			flag1 = true;
			estaVazio($("#numDoc"));
		}
		else {
			flag1 = false;
			retiraErro($("#numDoc"));
		}
		//Valida Multa
		if(($("#multa")).val().length < 1){
			flag2 = true;
			estaVazio($("#multa"));
		}
		else {
			flag2 = false;
			retiraErro($("#multa"));	
		}
		//Valida Valor
		if(($("#valor")).val().length < 1){
			flag4 = true;
			estaVazio($("#valor"));
		}
		else {
			flag4 = false;
			retiraErro($("#valor"));
		}
		if(!Date.parse($("#vencimento").val())){
			flag5= true;
			estaVazio($("#vencimento"));
		}
		else if(validaVencimento()){
			erroVencimento(this);		
		}else{
			flag5 = false;
			retiraErro($("#vencimento"));
		}
		if(($("#juros")).val().length < 1){
			flag6 = true;
			estaVazio($("#juros"));
		}
		else {
			flag6 = false;
			retiraErro($("#juros"));	
		}
		//Cancela submit caso haja erros.
		if(flag1 || flag2 || flag4 || flag5 || flag6){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível gerar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
		}
		else{
			email();
		}	
	});

	
});

$("#vencimento").focusout(function(){
	if(!Date.parse($(this).val()))
		estaVazio(this);
	else if(validaVencimento())
		erroVencimento(this);
	else
		retiraErro(this);	
});
$("#numDoc").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else
		retiraErro(this);	
});
$("#multa").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else
		retiraErro(this);	
});
$("#juros").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else
		retiraErro(this);	
});
$("#valor").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else
		retiraErro(this);	
});

function estaVazio(campo){
	var pai = $(campo).closest("div");	
	pai.attr("class", pai.attr("class")+" has-error");
	var erro = $(campo).next();
	erro.attr("class", "alert alert-danger");
	erro.html("Preencha este campo!");
	flag_error = true;
}

function erroVencimento(campo){
	var pai = $(campo).closest("div");	
	pai.attr("class", pai.attr("class")+" has-error");
	var erro = $(campo).next();
	erro.attr("class", "alert alert-danger");
	erro.html("Vencimento Inválido!");
	flag_error = true;
}

function retiraErro(campo){
	var pai = $(campo).closest("div");	
	var classe = pai.attr("class");
	classe = classe.replace(/(\has-error)/g, "");
	pai.attr("class", classe);
	var erro = $(campo).next();
	erro.attr("class", "");
	erro.html("");
}

function validaVencimento(){
	var atual = new Date();
	var dd = atual.getDate();
	var mm = atual.getMonth()+1; //January is 0!
	var yyyy = atual.getFullYear();

	if(dd<10) {
		dd = '0'+dd
	} 
	if(mm<10) {
		mm = '0'+mm
	} 
	atual = yyyy + '-' + mm + '-' + dd;
	return Date.parse($("#vencimento").val()) < Date.parse(atual);
}

function email(){
	var xmlhttp = new XMLHttpRequest();
	var xmlhttp1 = new XMLHttpRequest();

	xmlhttp1.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			window.location.href = "http://" + window.location.hostname + ":" + window.location.port + "/BoletoPHP/GerenciadorBoleto/boletos.php";
		}
	};

	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var url1 = "/BoletoPHP/GerenciadorBoleto/email.php";
			xmlhttp1.open("GET", url1 , true);
			xmlhttp1.send();
		}
	};
	var cod = $("#cliente").val();
	var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=enviarEmail&cod=" + cod;
	xmlhttp.open("GET", url , true);
	xmlhttp.send();
}
