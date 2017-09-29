//Máscara CEP
$(document).ready(function () {
    $("#cep").val(cep($("#cep").val()));
    $("#cep").keypress(function () {
        v_obj = this;
        v_fun = cep;
        setTimeout('execmascara()', 1);
    });
});

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function cep(v) {

    //Remove tudo o que não é dígito
    v = v.replace(/\D/g, "");

    //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{2})(\d)/, "$1.$2");

    //Coloca um hífen entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d{1,3})$/, "$1-$2");

    return v;
}