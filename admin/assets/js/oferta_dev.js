EditarOferta = function (oferta_id , acao , nameForm) {
    $.ajax({
        type: "POST",
        data: {oferta_id: oferta_id, acao: acao},
        dataType: "json",
        url: "./ajax/ajax_load.php",
        beforeSend: function () {
            $('#loading2').modal('show');
        },
        success: function (data)
        {
            var result = data;
            $('#oferta_observacao_div').hide();
            $.each(result, function (k, v) {
                if (v) {
                    $('form[name="' + nameForm + '"] .' + k).val(v);
                    $('form[name="' + nameForm + '"] .' + k).attr('checked', v);
                    $('form[name="' + nameForm + '"] .' + k).attr("src", v);
                }
            });
            if (!$.isEmptyObject(data.nome)) {
                $("#oferta_comprador").html(data.nome);
            } 
            if (!$.isEmptyObject(data.valor_oferta)) {
                $('#oferta_oferta').html(data.valor_oferta);
            } 
            if (!$.isEmptyObject(data.observacao)) {
                $('#oferta_observacao_div').show();
                $('#oferta_observacao').html(data.observacao);
            }
            $('#loading2').modal('hide');
        },
        error: function () { }
    }).fail(function () {
        $('#loading2').modal('hide');
        alert('Tente mais tarde.');
    });
}