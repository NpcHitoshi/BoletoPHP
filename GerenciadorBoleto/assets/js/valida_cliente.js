$(document).ready(function(){ 
	//Validações ao tentar Submit
	$("form").submit(function(e){
		//Valida CPF
		console.log("asasa");
		if($("#cnpj").val().length < 1)
			estaVazio($("#cnpj"));
		else if(valida_cnpj($("#cnpj").val()))
			retiraErro($("#cnpj"));	
		//Valida Captcha
		if($("#captcha").val().length < 1)
			estaVazio($("#captcha"));
		else 
			retiraErro($("#captcha"));
		//Valida Nome	
		if(($("#nome")).val().length < 1)
			estaVazio($("#nome"));
		else 
			retiraErro($("#nome"));
		//Valida E-mail	
		if(($("#email")).val().length < 1)
			estaVazio($("#email"));
		else 
			retiraErro($("#email"));	
		// Valida CEP
		if(($("#cep")).val().length < 1)
			estaVazio($("#cep"));
		else 
			retiraErro($("#cep"));	
		//Valida Rua
		if(($("#rua")).val().length < 1)
			estaVazio($("#rua"));
		else 
			retiraErro($("#rua"));	
		//Valida Numero
		if(($("#num")).val().length < 1)
			estaVazio($("#num"));
		else 
			retiraErro($("#num"));	
		//Valida Estado
		if(($("#estado")).val().length < 1)
			estaVazio($("#estado"));
		else 
			retiraErro($("#estado"));	
		//Valida Cidade
		if(($("#cidade")).val().length < 1)
			estaVazio($("#cidade"));
		else 
			retiraErro($("#cidade"));	
		//Valida Bairro
		if(($("#bairro")).val().length < 1)
			estaVazio($("#bairro"));
		else 
			retiraErro($("#bairro"));
		if(flag_error){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível cadastrar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
		}	
	});

	
});

$("#cnpj").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else if(valida_cnpj($("#cnpj").val()))
		retiraErro(this);	
});
$("#captcha").focusout(function(){
	if($(this).val().length < 1)
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



function estaVazio(campo){
	var pai = $(campo).closest("div");	
	pai.attr("class", pai.attr("class")+" has-error");
	var erro = $(campo).next();
	erro.attr("class", "alert alert-danger");
	erro.html("Campo vazio! Este campo é obrigatório!");
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

function valida_cnpj (cnpj) {

	function multiplica_cnpj(cnpj, posicao = 5 ) {
            // Variável para o cálculo
            calculo = 0;
            
            // Laço para percorrer os item do cnpj
            for (i = 0; i < cnpj.length; i++ ) {
                // Cálculo mais posição do CNPJ * a posição
                calculo = calculo + ( cnpj[i] * posicao );
                
                // Decrementa a posição a cada volta do laço
                posicao--;
                
                // Se a posição for menor que 2, ela se torna 9
                if ( posicao < 2 ) {
                	posicao = 9;
                }
            }
            // Retorna o cálculo
            return calculo;
        }

    // Deixa o CNPJ com apenas números
    cnpj = cnpj.replace(/[^0-9]/g, '', cnpj);
    
    // O valor original
    cnpj_original = cnpj;
    
    // Captura os primeiros 12 números do CNPJ
    primeiros_numeros_cnpj = cnpj.substr(0, 12 );
    
    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */

    // Faz o primeiro cálculo
    primeiro_calculo = multiplica_cnpj(primeiros_numeros_cnpj );
    
    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    primeiro_digito = (primeiro_calculo % 11 ) < 2 ? 0 :  11 - (primeiro_calculo % 11);
    
    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    primeiros_numeros_cnpj += primeiro_digito;

    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    segundo_calculo = multiplica_cnpj(primeiros_numeros_cnpj, 6);
    segundo_digito = (segundo_calculo % 11) < 2 ? 0 :  11 - (segundo_calculo % 11);
    
    // Concatena o segundo dígito ao CNPJ
    cnpj = primeiros_numeros_cnpj + segundo_digito;
    
    // Verifica se o CNPJ gerado é idêntico ao enviado
    if (cnpj == cnpj_original) {
    	return true;
    }
    else{
    	var pai = $("#cnpj").closest("div");	
    	pai.attr("class", pai.attr("class")+" has-error");
    	var erro = $("#cnpj").next();
    	erro.attr("class", "alert alert-danger");
    	erro.html("CNPJ inválido!");
    	return false;
    }

}