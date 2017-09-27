//Carrega link para exclusão no modal dinamicamente.
$(document).ready(function(){
	$("#btexcluir").click(function(){
		link = $(this).attr("name");
		$("#Excsim").attr("href", link);
	})
})