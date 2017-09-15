$(document).ready(function(){
	$("form").submit(function(){
		var xmlhttp = new XMLHttpRequest();

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				alert("http://" + window.location.hostname + "/BoletoPHP/GerenciadorBoleto/email.php");
			}
		};
		var cod = $("#cliente").val();
		var url = "/BoletoPHP/GerenciadorBoleto/control/BoletoControl.php?action=enviarEmail&cod=" + cod;
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});