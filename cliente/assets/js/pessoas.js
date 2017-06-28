
$(document).tooltip({
    selector: '[data-toggle="tooltip"]'
});
inserirCampo = function (value, input) {
    if (input === 'nome') {
        $('input[name=nome]').val(value);
    }
}
new Autocomplete("nome", function () {

    this.setValue = function (value) {
        inserirCampo(value, 'nome');
    };
    this.setText = function (nome, id) {
        this.text.value = nome;//nome.replace(/'/g, "\\'"); 
        return this;
    };
    if (this.value.length < 1 && this.isNotClick)
        return;
    // O arquivo php abaixo é que será chamado via AJAX, sendo passado o parâmetro q com o valor digitado no campo
    return "ajax/ajax_autocomplete.php?action=nome&request=" + this.value;
//
});

new Autocomplete("email", function () {
    this.setValue = function (value) {
        inserirCampo(value, 'email');
    };
    this.setText = function (email, id) {
        this.text.value = email;
        return this;
    };
    if (this.value.length < 1 && this.isNotClick)
        return;
    // O arquivo php abaixo é que será chamado via AJAX, sendo passado o parâmetro q com o valor digitado no campo
    return "ajax/ajax_autocomplete.php?action=email&request=" + this.value;
//
});

$('form input').on('keypress', function (e) {
    return e.which !== 13;
});