$(document).ready(function(){ 
	//Validações ao tentar Submit
	$("form").submit(function(e){
		//Valida Banco
		//Valida Numero Documento
		if(($("#numDoc")).val().length < 1)
			estaVazio($("#numDoc"));
		else 
			retiraErro($("#numDoc"));
		//Valida Multa
		if(($("#multa")).val().length < 1)
			estaVazio($("#multa"));
		else 
			retiraErro($("#multa"));	
		// Valida Juros
		if(($("#juros")).val().length < 1)
			estaVazio($("#juros"));
		else 
			retiraErro($("#juros"));	
		//Valida Valor
		if(($("#valor")).val().length < 1)
			estaVazio($("#valor"));
		else 
			retiraErro($("#valor"));
		if(!Date.parse($("#vencimento").val()))
			estaVazio($("#vencimento"));
		else
			retiraErro($("#vencimento"));		
		console.log("jkasdjkasn");
		if(true){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível gerar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
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
