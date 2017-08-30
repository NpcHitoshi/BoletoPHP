$(function(){
    $("#buscar").keyup(function(){
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if( $(this).val().toString().toUpperCase() !== ""){
            $("."+tabela+" tbody>tr").hide();
            $("."+tabela+" td.busca:contains('" + $(this).val().toString().toUpperCase() + "')").parent("tr").show();
        } else{
            $("."+tabela+" tbody>tr").show();
        }
    }); 
});
$.extend($.expr[":"], {
    "contains-ci": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});

$(function(){
    $("#buscar1").keyup(function(){
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if( $(this).val().toString().toUpperCase() !== ""){
            $("."+tabela+" tbody>tr").hide();
            $("."+tabela+" td.busca:contains('" + $(this).val().toString().toUpperCase() + "')").parent("tr").show();
        } else{
            $("."+tabela+" tbody>tr").show();
        }
    }); 
});
$.extend($.expr[":"], {
    "contains-ci": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});

$(function(){
    $("#buscar2").keyup(function(){
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if( $(this).val().toString().toUpperCase() !== ""){
            $("."+tabela+" tbody>tr").hide();
            $("."+tabela+" td.busca:contains('" + $(this).val().toString().toUpperCase() + "')").parent("tr").show();
        } else{
            $("."+tabela+" tbody>tr").show();
        }
    }); 
});
$.extend($.expr[":"], {
    "contains-ci": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});

$(function(){
    $("#buscar3").keyup(function(){
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if( $(this).val().toString().toUpperCase() !== ""){
            $("."+tabela+" tbody>tr").hide();
            $("."+tabela+" td.busca:contains('" + $(this).val().toString().toUpperCase() + "')").parent("tr").show();
        } else{
            $("."+tabela+" tbody>tr").show();
        }
    }); 
});
$.extend($.expr[":"], {
    "contains-ci": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});


