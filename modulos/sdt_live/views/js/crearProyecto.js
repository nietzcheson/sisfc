$(document).ready(function(){
	server = "http://"+window.location.hostname;

	//habilito todos los elementos en la lista de uruarios
	$("#director").change(function(){
		$("#usuarios option").each(function(index, elemento){
			$(elemento).attr("disabled",false);
		});
		$("#elegidos option").each(function(index, elemento){
			$(elemento).attr("disabled",false);
		});
		//bloqueo la persona que fue elegida como director
		$("#usuarios option[value="+ $(this).val() +"]").attr("disabled",true);
		$("#elegidos option[value="+ $(this).val() +"]").attr("disabled",true);
		$('#seleccionados').val($("#elegidos").val());
	});
	//De la lista de los usuarios no incluidos en el proyectos, los seleccionados pasan a la otra lista
	$("#usuarios").click(function(){
		if ($(this).val()) {
			var res = "" + $(this).val() + "";
			var res = res.split(",");
			for (var i = 0; i < res.length; i++) {
				$('#elegidos').append('<option value="'+res[i]+'" selected>'+$("#usuarios option[value='"+res[i]+"']").text()+'</option>');
				$("#usuarios option[value='"+res[i]+"']").remove();
			}
			ordenarSelect('elegidos');
			$('#seleccionados').val($("#elegidos").val());
		};
	});
	//De la lista de los usuarios incluidos en el proyectos, los seleccionados pasan a la otra lista
	$("#elegidos").click(function(){
		if ($(this).val()) {
			var res = "" + $(this).val() + "";
			var res = res.split(",");
			for (var i = 0; i < res.length; i++) {
				$('#usuarios').append('<option value="'+res[i]+'" >'+$("#elegidos option[value='"+res[i]+"']").text()+'</option>');
				$("#elegidos option[value='"+res[i]+"']").remove();
			}
			ordenarSelect('usuarios');
			$('#seleccionados').val($("#elegidos").val());
		};
	});
	$("#enviarForm").click(function(){
		$("#elegidos option").each(function(index, elemento){
			$(elemento).attr("selected",true);
		});
		$('#seleccionados').val($("#elegidos").val());
	});
});

var ordenarSelect  = function(id_componente)
{
  var selectToSort = jQuery('#' + id_componente);
  var optionActual = selectToSort.val();
  selectToSort.html(selectToSort.children('option').sort(function (a, b) {
    return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
  })).val(optionActual);
}
