$(document).ready(function(){

	//alert("Listo");

	$(".close").click(function(){
		$(".alert").fadeOut(200);
	});
	
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


    $(function() {
    	$( ".datepicker" ).datepicker();
  	});

    $("div[id^='tabs_'] a").click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })


  $(function () {
    $('#myTab a:last').tab('show')
  })

	
});