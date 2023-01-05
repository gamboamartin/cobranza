let text_razon_social = $("#razon_social");
let text_cliente = $("#descripcion");
let text_nombre = $("#nombre");
let text_ap = $("#ap");
let text_am = $("#am");


text_nombre.change(function() {
    text_razon_social.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
    text_cliente.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
});

text_ap.change(function() {
    text_razon_social.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
    text_cliente.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
});

text_am.change(function() {
    text_razon_social.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
    text_cliente.val(text_nombre.val() + ' ' + text_ap.val() + ' ' + text_am.val());
});