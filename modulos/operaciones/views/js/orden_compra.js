$(document).ready(function(){

    server = "http://"+window.location.hostname;

    var referencia=$("#refere").val();
    var proveedor="";
    var factura="";
    var orden="";
    var getContactoCliente = function(){
        $.post(server+'/operaciones/getProductos','id='+$("#id_u_proveedor").val(),function(datos){

            $("#producto").append('<option>Seleccione</option>');
            for(var i = 0; i < datos.length; i++){
                $("#producto").append('<option value="' + datos[i].id_u_producto + '">' + datos[i].codigo_producto +" - "+ datos[i].nombre_producto + '</option>');
            }

        }, 'json');
        $('#producto').removeAttr('disabled');
    }
    $("#id_u_proveedor").change(function(){
        $("#producto").html('');
        $('#producto').attr('disabled','-1')
        getContactoCliente();
    });
    $("#agregarP").click(function(){
        if ($("#cantidad").val()!="" && $("#precio").val()!="" && $("#producto option:selected").html()!="Seleccione") {
            if (proveedor=="") {
                proveedor=$('#id_u_proveedor').val();
            };
            if (factura=="") {
                numero_factura=$('#numero_factura').val();
            };
            if (proveedor!="Seleccione" && numero_factura!="") {
                if (orden=="") {
                     $.post(server+'/operaciones/guardarOrdenC','refe='+referencia+'&prov='+proveedor+'&num='+numero_factura,function(datos){
                        orden = datos;
                    }, 'json');
                };
                $.post(server+'/operaciones/guardarProducto','refe='+referencia+'&prov='+proveedor+'&num='+numero_factura+'&prod='+$("#producto").val()+'&cant='+$("#cantidad").val()+'&prec='+$("#precio").val(),function(datos){
                    if(datos=="listo"){
                        tabla = $("#tabla_productos");
                        nume=$("tr").length;
                        $('#id_u_proveedor').attr('disabled','-1');
                        $('#numero_factura').attr('disabled','-1');
                        //boton= $('<button type="button" class="btn btn-danger" id="b-eliminar_'+nume+'"><span class="glyphicon glyphicon-trash"></span></button>');
                        td1 = $('<td name="nombre_'+nume+'" >'+$("#producto option:selected").html()+'</td>');
                        td2 = $('<td name="cantid_'+nume+'">'+$("#cantidad").val()+'</td>');
                        td3 = $('<td name="precio_'+nume+'">'+$("#precio").val()+'</td>');
                        td4 = $('<td></td>');
                        tr = $('<tr id="tr_'+nume+'"></tr>');
                        tr.append(td1);
                        tr.append(td2);
                        tr.append(td3);
                        //td4.append(boton);
                        tr.append(td4);
                        tabla.append(tr);

                    }
                }, 'json');
            }else{
                proveedor="";
                numero_factura="";
            };

        };

    });
});
