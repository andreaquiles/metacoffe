jQuery(function () {
    NumeroInteiros('n_lote');
    NumeroInteiros('qtde_sacas');
    NumeroInteiros('porc_umidade');
    NumeroInteiros('quebra_f13_cata');
    NumeroInteiros('defeitos');
    NumeroInteiros('gpi');
    NumeroInteiros('impurezas');
    NumeroInteiros('f10');
    NumeroInteiros('pva');
    NumeroInteiros('peneiras');
    NumeroInteiros('17_acima');
    NumeroInteiros('13_abaixo');
    NumeroInteiros('14_15_16');
    $("input.percentual").maskMoney({decimal: ".", thousands: ".", allowZero: true});


//    $(document).on('change', '.btn-file :file', function () {
//
//        var input = $(this),
//        numFiles = input.get(0).files ? input.get(0).files.length : 1,
//        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
//        input.trigger('fileselect', [numFiles, label]);
//    });
//
//    $(document).ready(function () {
//        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
//            var time = 90;
//            var count = 0;
//            form = new FormData();
//            form.append('myfile', event.target.files[0]); // para apenas 1 arquivo
//            $('#loading2').modal('show');
//
//            $.ajax({
//                url: 'amostra_editar.php', // Url do lado server que vai receber o arquivo
//                data: form,
//                cache: false,
//                processData: false,
//                contentType: false,
//                type: 'POST',
//                dataType: 'json',
//                success: function (data) {
//                    if (data.error) {
//                        messagesModal(data);
//                        $('#loading2').modal('hide');
//                    } else {
//                        count = data.produtos.length;
//                        alert(count);
////                        $.each(data.produtos, function (key, produto) {
////                            function delayed() {
////                                mais_campos_html(campos_items, true);
////                                inserirCamposProdutoDinamyc(
////                                        (campos_items - 1),
////                                        produto.produto_id,
////                                        produto.codigo_barras,
////                                        produto.quantidade,
////                                        produto.item);
////                                campos_items_import++;
////                                if (campos_items_import === count) {
////                                    $('#loading2').modal('hide');
////                                    campos_items_import = 0;
////                                }
////                            }
////                            setTimeout(delayed, time);
////                            time += 90;
////                        });
//
//                    }
//                }
//            });
//        });
//    });

});