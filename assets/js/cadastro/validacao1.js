$(document).ready(function () { 
    const $nome = $("#nome");
    const $sobrenome = $("#sobrenome");
    const $email = $("#email");
    const $cpf = $("#cpf");
    
    $cpf.mask('000.000.000-00', {reverse: false});
});