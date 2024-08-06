$(document).ready(function(){
    const textTarget = $('.carlos');
    const textChange = $('.textChange');

    textTarget.hover(() => {
        textChange.text('Tudo sobre o carlos');
    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
$(document).ready(function(){
    const textTarget = $('.henrique');
    const textChange = $('.textChange');

    textTarget.hover(() => {
        textChange.text('Tudo sobre o henrique');
    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});
$(document).ready(function(){
    const textTarget = $('.wellington');
    const textChange = $('.textChange');

    textTarget.hover(() => {
        textChange.text('Tudo sobre o wellington');
    });

    textTarget.addEventListener('mouseout', () => {
        textChange.text('Texto original');
    });
});