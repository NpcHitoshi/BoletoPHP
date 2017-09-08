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
		else{
			flag5 = false;
			retiraErro($("#vencimento"));		
		}
		//Cancela submit caso haja erros.
		if(flag1 || flag2 || flag4 || flag5){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível gerar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
		}
		else{
			//Recarrega página após gerar boleto
			console.log("Foooi");
			window.location.replace("https://stackoverflow.com/questions/503093/how-to-redirect-to-another-webpage");
			console.log("Foooi2");
		}	
	});

	
});

$("#vencimento").focusout(function(){
	if(!Date.parse($(this).val()))
		estaVazio(this);
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

function retiraErro(campo){
	var pai = $(campo).closest("div");	
	var classe = pai.attr("class");
	classe = classe.replace(/(\has-error)/g, "");
	pai.attr("class", classe);
	var erro = $(campo).next();
	erro.attr("class", "");
	erro.html("");
}
