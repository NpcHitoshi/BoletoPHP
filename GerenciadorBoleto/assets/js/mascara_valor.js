$(document).ready(function() {
    $("#valor").on("keyup", function() {
        // allow numbers, a comma or a dot
        alert("foi");
        var v= $(this).val(), vc = v.replace(/[^0-9,\.]/, '');
        if (v !== vc)        
            $(this).val(vc);
    });
});