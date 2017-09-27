//Carrega dados CEP.
//Prepara JQuery para execução.
$(document).ready(function(){
	//Executa bloco de código quando campo CEP perde foco.
	$("#cep").on('focusout', function(){
		//Estabelece objeto para requisição AJAX.
		var xmlhttp = new XMLHttpRequest();
		//Bloco que trata retorno da requisição
		xmlhttp.onreadystatechange = function() {
			//Caso sucesso.
			if (this.readyState == 4 && this.status == 200) {
				//TRata retorno JSON para Objeto.
				myObj = JSON.parse(this.responseText);
				//Seta campos.
				$("#rua").val(retira_acentos(myObj.tipo_logradouro.toUpperCase() + " " + retira_acentos(myObj.logradouro.toUpperCase())));
				$("#estado").val(retira_acentos(myObj.uf.toUpperCase()));
				$("#cidade").val(retira_acentos(myObj.cidade.toUpperCase()));
				$("#bairro").val(retira_acentos(myObj.bairro.toUpperCase()));
			}
		};
		//Executa requisição AJAX.
		var url = "http://cep.republicavirtual.com.br/web_cep.php?cep="+ $(this).val() +"&formato=json";
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});
//Retira acentos do endereço, para padronzar com o Insert do DB;
function retira_acentos(palavra) { 
    com_acento = 'áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ'; 
    sem_acento = 'aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC'; 
    nova=''; 
    for(i=0;i<palavra.length;i++) { 
        if (com_acento.search(palavra.substr(i,1))>=0) { 
            nova+=sem_acento.substr(com_acento.search(palavra.substr(i,1)),1); 
        } 
        else { 
            nova+=palavra.substr(i,1); 
        } 
    } 
    return nova; 
}
