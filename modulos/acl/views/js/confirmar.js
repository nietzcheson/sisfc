$(document).ready(function() {
    $("div[id^='eliminar_']").click(function() {
        if (confirm("seguro que desea Eliminar"))
        {

        }
        else
        {
            event.preventDefault();
        };
    });
});