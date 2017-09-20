$(document).ready(function(){
	$("#cliente").on('select2:opening change', function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				myObj = JSON.parse(this.responseText);
				$("#numDoc").val(myObj.num);
			}
		};
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=carregaNumDocumento&cod=" + $(this).val();
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});
