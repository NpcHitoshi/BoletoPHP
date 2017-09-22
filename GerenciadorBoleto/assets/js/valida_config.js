$(document).ready(function(){ 
	//Validações ao tentar Submit
	$("#form-emp").submit(function(e){
		//Valida CPF
		if($("#documento").val().length < 1){
			flag1 = true;
			estaVazio($("#documento"));
		}
		else if(valida_cnpj($("#documento").val())){
			flag1 = false;
			retiraErro($("#documento"));	
		}
		//Valida Nome	
		if(($("#nome")).val().length < 1){
			flag3 = true;
			estaVazio($("#nome"));
		}
		else {
			flag3 = false;
			retiraErro($("#nome"));
		}
		//Valida E-mail	
		if(($("#email")).val().length < 1){
			flag4 = true;
			estaVazio($("#email"));
		}
		else {
			flag4 = false;
			retiraErro($("#email"));	
		}
		// Valida CEP
		if(($("#cep")).val().length < 1){
			flag5 = true;
			estaVazio($("#cep"));
		}
		else {
			flag5 = false;
			retiraErro($("#cep"));	
		}
		//Valida Rua
		if(($("#rua")).val().length < 1){
			flag6 = true;
			estaVazio($("#rua"));
		}
		else {
			flag6 = false;
			retiraErro($("#rua"));	
		}
		//Valida Numero
		if(($("#num")).val().length < 1){
			flag7 = true;
			estaVazio($("#num"));
		}
		else {
			flag7 = false;
			retiraErro($("#num"));	
		}
		//Valida Estado
		if(($("#estado")).val().length < 1){
			flag8 = true;
			estaVazio($("#estado"));
		}
		else {
			flag8 = false;
			retiraErro($("#estado"));	
		}
		//Valida Cidade
		if(($("#cidade")).val().length < 1){
			flag9 = true;
			estaVazio($("#cidade"));
		}
		else {
			flag9 = false;
			retiraErro($("#cidade"));	
		}
		//Valida Bairro
		if(($("#bairro")).val().length < 1){
			flag10 = true;
			estaVazio($("#bairro"));
		}
		else {
			flag10 = false;
			retiraErro($("#bairro"));
		}
		if(flag1 || flag3 || flag4 || flag5 || flag6 || flag7 || flag8 || flag9 || flag10){
			$("#erro-submit").attr("class", $("#erro-submit").attr("class")+" alert alert-danger");
			$("#erro-submit").html("Não é possível cadastrar! Conserte os erros de preenchimento antes!");
			e.preventDefault();
		}
		else{
			cadastrar();
		}
		flag1 = flag2 = flag3 = flag4 = flag5 = flag6 = flag7 = flag8 = flag9 = flag10 = false; 	
	});

	$("#form-banco").submit(function(e){
		if($("#agencia").val().length < 1){
			flag1 = true;
			estaVazio($("#agencia"));
		}else{
			flag1= false;
			retiraErro($("#agencia"));
		}
		if($("#conta").val().length < 1){
			flag1 = true;
			estaVazio($("#conta"));
		}else{
			flag1= false;
			retiraErro($("#conta"));
		}
		if($("#dv").val().length < 1){
			flag1 = true;
			estaVazio($("#dv"));
		}else{
			flag1= false;
			retiraErro($("#dv"));
		}


	});

	
});

$("#documento").focusout(function(){
	if($(this).val().length < 1)
		estaVazio(this);
	else if(valida_cnpj($("#documento").val()))
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