$(document).ready(function(){
    const textTarget = $('.carlos');
    const textChange = $('.textChange');
    const nomes = $('.nomes');

    textTarget.hover(() => {
        nomes.text('Carlos');
        textChange.text('Tudo sobre o carlos');

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
        textChange.text('Tudo sobre o henrique');
        nomes.text('henrique')

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
        textChange.text('Tudo sobre o wellington');
        nomes.text('wellington')

    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
const nomes = $('.nomes');

    textTarget.hover(() => {
        nomes.text('Carlos')
})