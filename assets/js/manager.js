//
//$("#loading2").modal({keyboard: false, backdrop: 'static', show: false});
//
//$(window).on('beforeunload', function () {
//    $('#loading2').modal('show');
//});
//
//$(document).on('focus', '[data-toggle="maskMoney"]', function () {
//    $(this).maskMoney({
//        thousands: '.',
//        decimal: ',',
//        allowZero: true
//    });
//});

$(document).ready(function () { //pronto para executar o js
    //CAPAZ DE EXECUTAR O JS


    $('form:not(.noAjax)').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        //form.find('[type=submit]').attr('data-loading-text', 'Aguarde...').button('loading');
        $.post(form.attr('action'), form.serialize(), function (data) {
            $('input').css('border-color', function () {
                return '#ccc';//*cinza
            });
            $('div .alert-danger').remove();
            if (data.success) {
                if (data.modal) {
                    messagesModal(data);
                } else {
                    if (data.link) {
                        location.href = data.link;
                    }
                    $('#alerta').html('<div class="alert alert-success \n\ fade in" role="alert">'
                            + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                            + data.success + '</div>');

                }

            } else if (data.error) {
                if (data.error_input) {
                    $('input[name="' + data.error_input + '"').css('border-color', function () {
                        return '#a94442';//*danger
                    });
                    $('input[name="' + data.error_input + '"').after('<div class="alert alert-danger alerta_input" style="padding:5px" role="alert">'
                            + '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> '
                            + '<span class="sr-only">Error:</span>'
                            + data.error
                            + '</div>');
                    $('input[name="' + data.error_input + '"').focus();
                } else {
                    $('#alerta').html('<div class="alert alert-danger" role="alert"> '
                            + '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> '
                            + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                            + data.error + '</div>');
                }
            } else if (data.success2) {
                $('#myModal2').modal('hide');
                location.reload();
                // document.location.href = document.location.href;//+'?inserir=contato';
            } else if (data.error2) {
                $('#myModal2').modal('hide');
                $('#alerta2').html('<div class="alert alert-danger" role="alert">'
                        + data.error2 + '</div>');
            }
        }, 'json').always(function () {
            //form.find('[type=submit]').button('reset');
        }).fail(function () {
            alert('Tente mais tarde.');
        });
    });


    messagesModal = function (data) {
        if (!$.isEmptyObject(data)) {
            if (data.error) {
                $('<div class="modal" aria-hidden="true">'
                        + '<div class="modal-dialog">'
                        + '<div class="modal-content panel-danger">'
                        + '<div class="modal-header panel-heading">'
                        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        + '<h4 class="modal-title" id="exampleModalLabel">&nbsp;Alerta</h4>'
                        + '</div>'
                        + '<div class="modal-body">'
                        + ($.isEmptyObject(data.error) ? data.error.join('<br>') : data.error)
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>')
                        .on('shown.bs.modal', function () {
                            var _modal = $(this);
                            _modal.find("button:first").focus();
                            setTimeout(function () {
                                _modal.modal('hide');
                            }, 3000);
                        })
                        .on('hidden.bs.modal', function () {
                            $(this).remove();
                            if (data.link) {
                                location.href = data.link;
                            }
                            if (data.reload === true) {
                                location.reload();
                            }
                        })
                        .modal('show');
            } else if (data.success) {
                $('<div class="modal fade" aria-hidden="true">'
                        + '<div class="modal-dialog">'
                        + '<div class="modal-content panel-success">'
                        + '<div class="modal-header panel-heading">'
                        + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        + '<h4 class="modal-title" id="exampleModalLabel">&nbsp;Alerta</h4>'
                        + '</div>'
                        + '<div class="modal-body">'
                        + ($.isEmptyObject(data.success) ? data.success.join('<br>') : data.success)
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '</div>')
                        .on('shown.bs.modal', function () {
                            var _modal = $(this);
                            _modal.find("button:first").focus();
                            setTimeout(function () {
                                _modal.modal('hide');
                            }, 3000);
                        })
                        .on('hidden.bs.modal', function (e) {
                            $(this).remove();
                            if (data.link) {
                                location.href = data.link;
                            }
                            if (data.reload === true) {
                                location.reload();
                            }
                        })
                        .modal('show');
            } else if (data.link) {
                location.href = data.link;
            } else if (data.reload === true) {
                location.reload();
            }
        }
    };

});

$(function () {
//    $('INPUT[type="file"]').change(function () {
//        //var ext = this.value.match(/\.(.+)$/)[1];
//        var myFile = this.value.split(".");
//        var size = myFile.length;
//        var extension = myFile[size - 1];
//        switch (extension) {
//            case 'jpg':
//            case 'jpeg':
//            case 'png':
//            case 'gif':
//            case 'bmp':
//            case 'mp3':
//            case 'wav':
//            case 'mp4':
//            case'mov':
//                //$('#uploadButton').attr('disabled', false);
//                break;
//            default:
//                $('#alerta').html('<div class="alert alert-danger" role="alert">'
//                        + 'Este arquivo não é permitido(  ' + extension + '  ) </div>');
//                this.value = '';
//        }
//    });

//    $('#form_listen').ajaxForm({
//        success: function () {
//            // if (data == 1) {
//            //se for sucesso, simplesmente recarrego a página. Aqui você pode usar sua imaginação.
//            location.reload();
//        }
//    });
//
//    NumeroInteiros = function (campo) {
//        $("input[name='" + campo + "']").bind("keyup blur focus", function (e) {
//            e.preventDefault();
//            var expre = /[^0-9]/g;
//            // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
//            if ($(this).val().match(expre))
//                $(this).val($(this).val().replace(expre, ''));
//        });
//    };
//    NumeroInteiros('numero');
});

