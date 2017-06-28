
$(document).tooltip({
    selector: '[data-toggle="tooltip"]'
});
inserirCampo = function (value, input) {
    if (input === 'bebida') {
        $('input[bebida=bebida]').val(value);
    }
}
new Autocomplete("bebida", function () {

    this.setValue = function (value) {
        inserirCampo(value, 'bebida');
    };
    this.setText = function (field, id) {
        this.text.value = field.replace(/'/g, "\\'"); 
        return this;
    };
    if (this.value.length < 1 && this.isNotClick)
        return;
    // O arquivo php abaixo é que será chamado via AJAX, sendo passado o parâmetro q com o valor digitado no campo
    return "ajax/ajax_autocomplete.php?action=bebida&request=" + this.value;
//
});

$('form input').on('keypress', function (e) {
    return e.which !== 13;
});