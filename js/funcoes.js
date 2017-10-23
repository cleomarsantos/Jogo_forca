$(document).ready(function(){
    $('#cadastro').on('keypress', function() {
    var regex = new RegExp("^[ 0-9a-zA-Zàèìòùáéíóúâêîôûãõ\b]+$");
    var _this = this;
    // Curta pausa para esperar colar para completar
    setTimeout( function(){
        var texto = $(_this).val();
        if(!regex.test(texto))
        {
            $(_this).val(texto.substring(0, (texto.length-1)))
        }
    }, 100);
    });

    $('.btn').on('click', function() {
        var valor = $(this).val();
        window.location.assign("?pagina=jogar&letra="+valor);
    });

    $(".disabled :button").attr("disabled", true);

}); 