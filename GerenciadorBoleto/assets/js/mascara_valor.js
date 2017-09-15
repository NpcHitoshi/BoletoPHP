$(document).ready(function(){
	$("#valor").keypress(function(){
		v_obj=this;
		v_fun=moeda;
		setTimeout('execmascara()',1);
	});
        
        $("#juros").keypress(function(){
		v_obj=this;
		v_fun=moeda;
		setTimeout('execmascara()',1);
	});
});

function execmascara(){
	v_obj.value=v_fun(v_obj.value)
}

function moeda(v){ 
v=v.replace(/\D/g,"") // permite digitar apenas numero 
v=v.replace(/(\d{1})(\d{17})$/,"$1.$2") // coloca ponto antes dos ultimos digitos 
v=v.replace(/(\d{1})(\d{13})$/,"$1.$2") // coloca ponto antes dos ultimos 13 digitos 
v=v.replace(/(\d{1})(\d{10})$/,"$1.$2") // coloca ponto antes dos ultimos 10 digitos 
v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 7 digitos 
v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 2 digitos 
v = "R$" + v; 
return v;
}