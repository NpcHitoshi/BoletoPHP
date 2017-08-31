$(document).ready(function(){ 
	$("#cnpj").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#captcha").focusout(function(){
		if($(this).val().length < 5)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#nome").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#email").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#cep").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#rua").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#num").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#estado").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#cidade").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});
	$("#bairro").focusout(function(){
		if($(this).val().length < 1)
			estaVazio(this);
		else
			retiraErro(this);	
	});


});

function estaVazio(campo){
	var pai = $(campo).closest("div");	
	pai.attr("class", pai.attr("class")+" has-error");
	var erro = $(campo).next();
	erro.attr("class", "alert alert-danger");
	erro.html("Campo vazio! Este campo é obrigatório!");
}

function retiraErro(campo){
	var pai = $(campo).closest("div");	
	var classe = pai.attr("class");
	classe = classe.replace(/(\has-error)/g, "");
	console.log(classe);
	pai.attr("class", classe);
	var erro = $(campo).next();
	erro.attr("class", "");
	erro.html("");
}