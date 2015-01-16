$(document).ready(function(){
    server = "http://"+window.location.hostname;
    var monto;
    var moneda;
    $("#checkAll").click(function(){
        var valor = $("#checkAll").prop("checked");
        $("input[id^='checktipo_']" ).each(function(index, elemento){
            $(elemento).prop("checked",valor);
        });
    });
    $("button[id^='b-actualizar_']").click(function(){
        if(confirm("¿Está seguro de actualizar?")){
            var check = $("input[id^='checktipo_']:checked");
            for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);
                fecha=$("input[name^='fec_"+id+"']").val();
                monto=$("#monto_"+id).val();
                montoA=$("#montoA_"+id).val();
                mone=$("#mone_"+id).val();
                concep=$("#concep_"+id).val();
               	//alert('id=' + id + '&fecha=' + fecha+ '&monto=' + monto+ '&montoA=' + montoA+ '&mone=' + mone+ '&concep=' + concep)
                //$.post(server+'/operaciones/actualizarCxC','id=' + id + '&fecha=' + fecha+ '&monto=' + monto+ '&montoA=' + montoA+ '&mone=' + mone+ '&concep=' + concep);
                $.post(server+'/operaciones/actualizarCxC','id=' + id + '&fecha=' + fecha+ '&monto=' + monto+ '&montoA=' + montoA+ '&mone=' + mone+ '&concep=' + concep, function(datos){
                    alert(datos);
                    if (datos=='listo') {
                    };
                }, 'json');
            }
        }
    });
    $("button[id^='b-eliminar_']").click(function(){
        if(confirm("¿Está seguro de actualizar?")){
            var check = $("input[id^='checktipo_']:checked");
            for(var i = 0; i < check.length; i++){
                id = $(check[i]).attr("id");
                id = id.slice(10,id.length);

                $.post(server+'/operaciones/eliminarCxC','id=' + id);
                $("#tr_"+id).fadeOut(200);
            }
        }
    });


    $("button[id^='factu_']").click(function(){

        id = $(this).attr("id");
        id = id.slice(6,id.length);
        $("#id_cxc").attr("value",id);
        monto = $("#montoA_"+id).val();
        moneda = $("#mone_"+id).val();
        $("#divisa").val(moneda);
        concepto = $("#concep_"+id+" option:selected").text();
        id_concepto = $("#concep_"+id+" option:selected").val();
        $("input[name='concepto']").val(id_concepto);
        $("#monto_factura").attr("value",monto);
        $("#descripcion").attr("value","Anticipo por pago de "+concepto);
        $("label[id^='moneda_']" ).each(function(index, elemento){
            if ($(elemento).attr("id")=="moneda_"+moneda) {
                $("#moneF_"+moneda).attr("checked",true);
                $("#divisa").val($("#moneF_"+moneda).val());
                $(elemento).attr('class', 'btn btn-primary active');
            }else{
                $(elemento).attr('class', 'btn btn-default');
            };
        });
    });
    $("label[id^='moneda_']").click(function(){
        id = $(this).attr("id");
        moneda = id.slice(7,id.length);
        $("label[id^='moneda_']" ).each(function(index, elemento){
            if ($(elemento).attr('id')==id) {
                $(elemento).attr('class', 'btn btn-primary');
                $("#divisa").val($("#moneF_"+moneda).val());
            }else{
                $(elemento).attr('class', 'btn btn-default');
            };
        });
    });

    $("button[id^='b_']").click(function(){

      id = $(this).attr("id");
      comprobante = id.slice(2,id.length);

      confirmar = confirm("¿Está seguro de cancelar?");

      if(confirmar==true){
        $("#f_"+comprobante).submit();
      }else{
        event.preventDefault();
      }

    });


    $(".enviar_pdfXML").click(function(){

      comprobante = $(this).attr("id");
      var emails = $("input[name='emails']").map(function(){return $(this).val();}).get();

      $("input[name='correos']").attr("value",emails);

      $("#enviarMailFactura"+comprobante).submit();
    });

    function eliminarWrapInput(){
      padre = $(elemento).parent();
      abuelo = $(padre).parent();

      $(abuelo).remove();
    }

    $("#delete-mail-rs").click(function(){
      $("#mail-rs").remove();
    });

    $("#nuevo-mail").click(function(){

      var inputGroup = $('<div />',{
        'class' : 'input-group',
      });

      var input = $('<input />',{
        'type'	: 'text',
        'class' : 'form-control',
        'name'	: 'emails'
      });

      var spanInput = $('<span />',{
        'class' : 'input-group-btn',
      });

      var button = $("<button />",{
        'class' : 'btn btn-default',
        'type'  : 'button',
        click : function(e){

          elemento = $(this);
          eliminarWrapInput();

        }
      });

      var glyphicon = $('<span />',{
        'class' : 'glyphicon glyphicon-remove'
      });

      var inputHTML = inputGroup.append(input,spanInput.append(button.append(glyphicon)));
      $("#wrap-mails").append("<h1></h1>",inputHTML);
    });



});
