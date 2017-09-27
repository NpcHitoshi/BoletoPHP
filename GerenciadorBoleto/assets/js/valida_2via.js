//Validações 2 via boleto.
$(document).ready(function(){ 
	//Validações ao tentar Submit
	$("#form-2via").submit(function(e){
		//Valida Valor
		if(($("#valor")).val().length < 1){
			flag1 = true;
			estaVazio($("#valor"));
		}
		else {
			flag1 = false;
			retiraErro($("#valor"));
		}
		//Valida Vencimento
		if(!Date.parse($("#vencimento").val())){
			flag2= true;
			estaVazio($("#vencimento"));
		}
		else{
			flag2 = false;
			retiraErro($("#vencimento"));		
		}
		//Cancela submit caso haja erros.
		if(flag1 || flag2){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível gerar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
		}
		else{
			//Recarrega página após gerar boleto
			window.location.replace("https://stackoverflow.com/questions/503093/how-to-redirect-to-another-webpage");
		}	
	});

	$("#vencimento").focusout(function(){
		if(!Date.parse($(this).val()))
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

