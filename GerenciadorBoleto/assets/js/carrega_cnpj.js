$(document).ready(function(){
	$("#captcha").focusout(function(){
		var ccnpj = $("#cnpj").val();
		var ccaptcha_cnpj = $("#captcha").val();
		var form_method = "POST";
		$.ajax({
			url: "http://localhost/BoletoPHP/GerenciadorBoleto/processa.php",
			type: "post",
			data: { 'cnpj': ccnpj, 'captcha_cnpj': ccaptcha_cnpj }
		});
		$("#nome").attr("placeholder", "Carregando...");
		$("#email").attr("placeholder", "Carregando...");
		$("#cep").attr("placeholder", "Carregando...");
		$("#rua").attr("placeholder", "Carregando...");
		$("#num").attr("placeholder", "Carregando...");
		$("#estado").attr("placeholder", "Carregando...");
		$("#cidade").attr("placeholder", "Carregando...");
		$("#bairro").attr("placeholder", "Carregando...");
		$("#complemento").attr("placeholder", "Carregando...");
		$.get("http://localhost/BoletoPHP/GerenciadorBoleto/processa.php", { 'cnpj': ccnpj, 'captcha_cnpj': ccaptcha_cnpj}, 
			function(returnedData){
				returnedData = tratamento(returnedData);
				var vetor = viravet(returnedData);
				if(vetor.lastIndex() != "OK     "){
					console.log("Erro WebService!");
					for(var a = 0; a< vetor.length; a++)
						console.log(a + vetor[a]);
				} else{
					$("#nome").val(vetor[3]+"");
					$("#email").val(vetor[21]+"");
					$("#cep").val(vetor[17]+"");
					$("#rua").val(vetor[14]+"");
					$("#num").val(vetor[15]+"");
					$("#estado").val(vetor[20]+"");
					$("#cidade").val(vetor[19]+"");
					$("#bairro").val(vetor[18]+"");
					$("#complemento").val(vetor[16]+"");
					for(var a = 0; a< vetor.length; a++)
						console.log(a + vetor[a]);
				}
				
			});
	});
});

function tratamento(array){
	return array.replace(/((Array)|\)|\(|=|\[[0-9]\])|(\[[0-9]|[0-9]\])/g, "");
}

function viravet(string){
	var vetor = string.split(">");
	for(var a = 0; a< vetor.length; a++){
		vetor[a]= vetor[a].replace(" ", "");
		vetor[a]= vetor[a].slice(0, vetor[a].length-5);
	}
	return vetor;
}

