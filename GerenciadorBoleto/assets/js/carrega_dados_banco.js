$(document).ready(function(){
	$("#selectBanco").on('select2:opening change', function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				$("#agencia").val(myObj.agencia);
                                $("#conta").val(myObj.contaCorrente);
                                $("#dv").val(myObj.digitoVerificador);
                                $("#juros").val(myObj.jurosPadrao);
                                $("#multa").val(myObj.multaPadrao);
			}
		};
                alert($(this).val());
		var url = "control/AdministradorControl.php?action=carregaDadosBanco&cod=" + $(this).val();
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});

