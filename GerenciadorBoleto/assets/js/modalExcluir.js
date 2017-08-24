$(document).ready(function(){
	$("#btexcluir").click(function(){
		link = $(this).attr("name");
		$("#Excsim").attr("href", link);
	})
})