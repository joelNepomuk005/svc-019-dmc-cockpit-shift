function setEqualHeight() {

    $('[data-equalheight]').each(function(){

        var $row = $(this);
        var selector = $row.data('equalheight').split(',');

        for (var i = 0; i < selector.length; i++) {

            $row.find(selector[i]).css({ 'height': 'auto' });

            var maxHeight = 0;
            $row.find(selector[i]).each(function(){
                var $element = $(this);
                if (parseInt($element.outerHeight()) > maxHeight) {
                    maxHeight = parseInt($element.outerHeight());
                }
            });

            $row.find(selector[i]).each(function(){
                $(this).css({ 'height': maxHeight + 'px' });
            })
        }

    });

}

$(function(){
    setEqualHeight();
    /* *********************************************************************** */

    /*
    *
    */

    $('window').on('resize orientationchange', function(){
        setEqualHeight();
    });
    $('window').trigger('resize');

    /* *********************************************************************** */

    /*
    *
    */

    $('#quicklinks_management_participants').on('change', function(event){
        window.location = $(this).find(':selected').val();
    })

    $('input[name$="alle_auswaehlen"]').on('click', function () {
        if ($(this).prop('checked') === true) {
            $('.form-check').prop('checked', true);
        } else {
            $('.form-check').prop('checked', false);
        }
    })

});
