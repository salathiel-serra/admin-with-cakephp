$(document).ready(function () {
    //Apresentar ou ocultar o menu
    $('.sidebar-toggle').on('click', function () {
        $('.sidebar').toggleClass('toggled');
    });
    
    //carregar aberto o submenu
    var active = $('.sidebar .active');
    if (active.length && active.parent('.collapse').length) {
        var parent = active.parent('.collapse');

        parent.prev('a').attr('aria-expanded', true);
        parent.addClass('show');
    }
});

function imagePreview() {
    var image   = document.querySelector('input[name=image]').files[0];
    var preview = document.querySelector('#image-preview');

    var reader = new FileReader();
    reader.onloadend = function(){
        preview.src = reader.result;
    }

    if (image) {
        reader.readAsDataURL(image);
    } else {
        preview.src = "";
    }
}