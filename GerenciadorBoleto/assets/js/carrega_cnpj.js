$(document).ready(function(){
	//Função acionada quando campo captcha perde foco.
	$("#captcha").focusout(function(){
		//Pega valores dos campos cnpj e captcha e seta junto do método POST.
		var ccnpj = $("#cnpj").val();
		var ccaptcha_cnpj = $("#captcha").val();
		var form_method = "POST";
		//Monta requisição AJAX;
		$.ajax({
			url: "http://localhost/BoletoPHP/GerenciadorBoleto/processa.php",
			type: "post",
			data: { 'cnpj': ccnpj, 'captcha_cnpj': ccaptcha_cnpj }
		});
		//Muda os placeholders
		setaplaceholder(1);
		//Envia via AJAX GET
		$.get("http://localhost/BoletoPHP/GerenciadorBoleto/processa.php", { 'cnpj': ccnpj, 'captcha_cnpj': ccaptcha_cnpj}, 
			function(returnedData){
				returnedData = tratamento(returnedData);
				var vetor = viravet(returnedData);
				//Verifica se achou dados.
				if(vetor[vetor.length-1].indexOf("OK") < 0){
					setaplaceholder(3);
				} else{
					setaCampos(vetor);
					setaplaceholder(1);
				}
			});
	});
});

function tratamento(array){
	//Trata HTML de retorno para transformar em vetor;
	return array.replace(/((\[status\])|(Array)|\)|\(|=|\[[0-9]\])|(\[[0-9]|[0-9]\])/g, "");
}

function viravet(string){
	//Separa as informações em vetor
	var vetor = string.split(">");
	for(var a = 0; a< vetor.length; a++){
		vetor[a]= vetor[a].replace(" ", "");
		vetor[a]= vetor[a].slice(0, vetor[a].length-5);
	}
	return vetor;
}

function setaplaceholder(status){
	switch(status){
		//Fazendo requisição
		case 1:
		$("#nome").attr("placeholder", "Carregando...");
		$("#email").attr("placeholder", "Carregando...");
		$("#cep").attr("placeholder", "Carregando...");
		$("#rua").attr("placeholder", "Carregando...");
		$("#num").attr("placeholder", "Carregando...");
		$("#estado").attr("placeholder", "Carregando...");
		$("#cidade").attr("placeholder", "Carregando...");
		$("#bairro").attr("placeholder", "Carregando...");
		$("#complemento").attr("placeholder", "Carregando...");
		break;
		//Falha ao encontrar parte dos dados
		case 2:
		$("#nome").attr("placeholder", "Não encontrado. Digite!");
		$("#email").attr("placeholder", "Não encontrado. Digite!");
		$("#cep").attr("placeholder", "Não encontrado. Digite!");
		$("#rua").attr("placeholder", "Não encontrado. Digite!");
		$("#num").attr("placeholder", "Não encontrado. Digite!");
		$("#estado").attr("placeholder", "Não encontrado. Digite!");
		$("#cidade").attr("placeholder", "Não encontrado. Digite!");
		$("#bairro").attr("placeholder", "Não encontrado. Digite!");
		$("#complemento").attr("placeholder", "Não encontrado. Digite!");
		break;
		//Nenhum dado encontrado
		case 3:
		$("#nome").attr("placeholder", "Nome Empresarial");
		$("#email").attr("placeholder", "E-mail");
		$("#cep").attr("placeholder", "CEP");
		$("#rua").attr("placeholder", "Rua");
		$("#num").attr("placeholder", "Número");
		$("#estado").attr("placeholder", "Estado");
		$("#cidade").attr("placeholder", "Cidade");
		$("#bairro").attr("placeholder", "Bairro");
		$("#complemento").attr("placeholder", "Complemento");
		break;
	}
}

function setaCampos(vetor){
	//Calcula posição dos campos no vetor com base no padrão de 23 posições e soma a sobra
	var sobra = vetor.length - 24;
	$("#nome").val(vetor[3]+"");
	$("#email").val(vetor[15+sobra]+"");
	$("#cep").val(vetor[11+sobra]+"");
	$("#rua").val(vetor[8+sobra]+"");
	$("#num").val(vetor[9+sobra]+"");
	$("#estado").val(vetor[14+sobra]+"");
	$("#cidade").val(vetor[13+sobra]+"");
	$("#bairro").val(vetor[12+sobra]+"");
	$("#complemento").val(vetor[16+sobra]+"");
}