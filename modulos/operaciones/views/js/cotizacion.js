$(document).ready(function(){
    $("#checkAll").click(function(){
        var valor = $("#checkAll").prop("checked");
        $("input[name^='orden_']" ).each(function(index, elemento){
            $(elemento).prop("checked",valor);
        });
    });
});