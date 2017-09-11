$(document).ready(function(){
	$(".btexcluir").click(function(){
		link = $(this).attr("name");
		$("#Excsime").attr("href", link);
	})
})

$(document).ready(function(){
	$(".btativar").click(function(){
		link = $(this).attr("name");
		$("#Excsima").attr("href", link);
	})
})

$(document).ready(function(){
	$(".bt2via").click(function(){
		link = $(this).attr("name");
		$("#form-2via").attr("action", link);
	})
})