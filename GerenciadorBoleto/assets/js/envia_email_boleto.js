$(document).ready(function(){
	$(".btn-email").click(function(){
		var xmlhttp = new XMLHttpRequest();
		var xmlhttp1 = new XMLHttpRequest();

		xmlhttp1.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				window.location.href = "http://" + window.location.hostname + ":" + window.location.port + "/BoletoPHP/GerenciadorBoleto/boletos.php";
			}
		};

		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var url1 = "/BoletoPHP/GerenciadorBoleto/email.php";
				xmlhttp1.open("GET", url1 , true);
				xmlhttp1.send();
			}
		};
		alert($(this).attr("href"));
		var url = $(this).attr("href");
		xmlhttp.open("GET", url , true);
		xmlhttp.send();
	});

});