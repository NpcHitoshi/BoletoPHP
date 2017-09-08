$(document).ready(function(){
	$("#cep").on('focusout', function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				console.log(myObj);
				$("#rua").val(retira_acentos(myObj.tipo_logradouro.toUpperCase() + " " + retira_acentos(myObj.logradouro.toUpperCase())));
				$("#estado").val(retira_acentos(myObj.uf.toUpperCase()));
				$("#cidade").val(retira_acentos(myObj.cidade.toUpperCase()));
				$("#bairro").val(retira_acentos(myObj.bairro.toUpperCase()));
			}
		};
		var url = "http://cep.republicavirtual.com.br/web_cep.php?cep="+ $(this).val() +"&formato=json";
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});

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
