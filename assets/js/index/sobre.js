$(document).ready(function(){
    const textTarget = $('.carlos');
    const textChange = $('.textChange');
    const nomes = $('.nomes');

    textTarget.hover(() => {
        nomes.text('Carlos');
        textChange.text('17 anos, teve o objetivo de cuidar da parte backend, frontend e na realização do banco de dados deste site com tendo um grande suporte na realização do site como um todo.');

    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
$(document).ready(function(){
    const textTarget = $('.henrique');
    const textChange = $('.textChange');
    const nomes = $('.nomes');


    textTarget.hover(() => {
        textChange.text('18 anos, teve como objetivo de prestar suporte aos demais participantes do grupo cuindando do frontend, backend e design em geral.');
        nomes.text('Henrique')

    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
$(document).ready(function(){
    const textTarget = $('.wellington');
    const textChange = $('.textChange');
    const nomes = $('.nomes');


    textTarget.hover(() => {
        textChange.text('17 anos, Wellington Gutierres teve como objetivo cuidar da lógica, banco de dados e design do site.');
        nomes.text('Wellington')

    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
const nomes = $('.nomes');

    textTarget.hover(() => {
        nomes.text('Carlos')
})