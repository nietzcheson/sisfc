$(document).ready(function(){
    server = "http://"+window.location.hostname;

    $("#checkAll").click(function(){
        var valor = $("#checkAll").prop("checked");
        $("input[id^='checktipo_']" ).each(function(index, elemento){
            $(elemento).prop("checked",valor);
        });
    });
     $("button[id^='b-actualizar_']").click(function(){
        if(confirm("¿Está seguro de actualizar?")){
            var check = $("input[id^='checktipo_']:checked");
            var id;
             for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);
                id_gasto = $("#gasto_"+id).val();
                valor = $("#valor_"+id).val();
                $.post(server+'/operaciones/actualizarGastosCotizaciones','id=' + id + '&id_gasto=' + id_gasto+ '&valor=' + valor);
            }
        }
    });
    $("button[id^='b-eliminar_']").click(function(){
        if(confirm("¿Está seguro de eliminar?")){
            var check = $("input[id^='checktipo_']:checked");
            var id;
             for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);
                $.post(server+'/operaciones/eliminarGastosCotizaciones','id=' + id);
                $("#tr_"+id).fadeOut(200);
            }
        }
    });
});