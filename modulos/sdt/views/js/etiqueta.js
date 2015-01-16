var server = "http://"+window.location.hostname;
$(document).ready(function(){
	$('select[name="colorpicker-picker-delay"]').simplecolorpicker({picker: true, theme: 'glyphicons', pickerDelay: 1000});
	$('select[name="colorpicker-picker-delay2"]').simplecolorpicker({picker: true, theme: 'glyphicons', pickerDelay: 1000});
	
	$("#color1").change(function(){
		var valor = $(this).val();
		$(".chek" ).each(function(index, elemento){
			if ($(elemento).prop('checked')) {
				var id = $(elemento).attr("id");
				id = id.slice(4,id.length);
				$("#et"+id).css('color',valor);
				$.post(server+'/sdt/actualizarEtiquetaColor','iden='+id+'&color='+valor);
			}
		});
	});
	$("#color2").change(function(){
		//$("#cuadro").css('background-color',$(this).val());
		var valor = $(this).val();
		$(".chek" ).each(function(index, elemento){
			if ($(elemento).prop('checked')) {
				var id = $(elemento).attr("id");
				id = id.slice(4,id.length);
				$("#et"+id).css('background-color',valor);
				$.post(server+'/sdt/actualizarEtiquetaBColor','iden='+id+'&bcolor='+valor);
			}
		});
	});
	$("#LetraFont").change(function(){
		//$("#cuadro").css('font-family',$(this).val());
		var valor = $(this).val();
		$(".chek" ).each(function(index, elemento){
			if ($(elemento).prop('checked')) {
				var id = $(elemento).attr("id");
				id = id.slice(4,id.length);
				$("#et"+id).css('font-family',valor);
				$.post(server+'/sdt/actualizarEtiquetaFamily','iden='+id+'&family='+valor);
				$("#et"+id).text($("#et"+id).css('font-family') + "  " + $("#et"+id).css('font-size'));
			}
		});
	});
	$("#LetraSize").change(function(){
		//$("#cuadro").css('font-size',$(this).val()+"px");
		var valor = $(this).val();
		$(".chek" ).each(function(index, elemento){
			if ($(elemento).prop('checked')) {
				var id = $(elemento).attr("id");
				id = id.slice(4,id.length);
				$("#et"+id).css('font-size',valor+"px");
				$.post(server+'/sdt/actualizarEtiquetaSize','iden='+id+'&size='+valor);
				$("#et"+id).text($("#et"+id).css('font-family') + "  " + $("#et"+id).css('font-size'));
			}
		});
	});
	$("#checkAll").click(function(){
        var valor = $("#checkAll").prop("checked");
        $(".chek" ).each(function(index, elemento){
            $(elemento).prop("checked",valor);
        });
    });
    $("input[id^='text']").change(function(){
    	var id = $(this).attr("id");
		id = id.slice(4,id.length);
		$.post(server+'/sdt/actualizarEtiquetaNombre','iden='+id+'&nombre='+$("#text"+id).val());
        //alert(id);
    });
});

function colorToHex(color) {
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);

    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);

    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] + '#' + rgb.toString(16);
};