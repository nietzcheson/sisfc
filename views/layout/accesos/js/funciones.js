$(document).ready(function(){

	//alert("Listo");

	$(".close").click(function(){
		$(".alert").fadeOut(200);
	});

	alert("Hola!");

	/*$(".nav-p").click(function(){
		$('.submenu').fadeIn(300);
	});*/

    $("button[id^='eliminar_']").click(function() {
        if (confirm("Seguro que desea eliminar"))
        {

        }
        else
        {
            event.preventDefault();
        };
    });

	
});