$(document).ready(function(){

    server = "http://"+window.location.hostname;

    $("button[id^='b-actualizar_']").click(function(){

        if(confirm("¿Está seguro de actualizar?")){
            var check = $("input[id^='checktipo_']:checked");
            var id;
            var valor;

             for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);
                valor = $("#tipo_campana_"+id).val();

                $.post(server+'/campanas/tipos_campana_actualizar',
                'id=' + id + '&valor=' + valor);
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
                $.post(server+'/campanas/tipos_campana_eliminar',
                'id=' + id);
                $("#tr_"+id).fadeOut(200);
            }
        }
    });

    $("#crear_tipo").click(function(){
        valor = $("#tipo_campana").val();

        $.post(server+'/campanas/tipos_campana_crear','nombre_tipo=' + valor,function(datos){            

            for(var i = 0; i < datos.length; i++){

                tabla = $("#tabla_tipos");
                input = $('<input type="text" class="form-control" value="'+datos[i].nombre+'" name="nombre_campana" id="tipo_campana_'+datos[i].id+'"/>');
                checkbox = $('<input class="form-control" type="checkbox" name="nombre_campana" id="checktipo_'+datos[i].id+'"/>');
                td1 = $('<td class="col-md-10"></td>');
                td2= $('<td class="col-md-2"></td>');
                tr = $('<tr id="tr_'+datos[i].id+'"></tr>');

                td1.append(input);
                td2.append(checkbox);
                tr.append(td1);
                tr.append(td2);
                tabla.append(tr);

               $("#tipo_campana").val("");

            }
            
        }, 'json');
    });

});