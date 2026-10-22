/******/ (() => { // webpackBootstrap
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
/*!**************************************!*\
  !*** ./resources/scripts/app/app.js ***!
  \**************************************/
function setEqualHeight() {
  $('[data-equalheight]').each(function () {
    var $row = $(this);
    var selector = $row.data('equalheight').split(',');
    for (var i = 0; i < selector.length; i++) {
      $row.find(selector[i]).css({
        'height': 'auto'
      });
      var maxHeight = 0;
      $row.find(selector[i]).each(function () {
        var $element = $(this);
        if (parseInt($element.outerHeight()) > maxHeight) {
          maxHeight = parseInt($element.outerHeight());
        }
      });
      $row.find(selector[i]).each(function () {
        $(this).css({
          'height': maxHeight + 'px'
        });
      });
    }
  });
}
$(function () {
  setEqualHeight();
  /* *********************************************************************** */

  /*
  *
  */

  $('window').on('resize orientationchange', function () {
    setEqualHeight();
  });
  $('window').trigger('resize');

  /* *********************************************************************** */

  /*
  *
  */

  $('#quicklinks_management_participants').on('change', function (event) {
    window.location = $(this).find(':selected').val();
  });
  $('input[name$="alle_auswaehlen"]').on('click', function () {
    if ($(this).prop('checked') === true) {
      $('.form-check').prop('checked', true);
    } else {
      $('.form-check').prop('checked', false);
    }
  });
});
})();

// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
(() => {
/*!***************************************************!*\
  !*** ./resources/scripts/app/components/forms.js ***!
  \***************************************************/
$(function () {
  $('[data-ajax-method="DELETE"]').click(function (event) {
    event.preventDefault();
    var $this = $(this);
    var $header = $this.data('dialog-header');
    var $body = $this.data('dialog-body');
    var $url = $this.data('href');
    var swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success text-white',
        cancelButton: 'btn btn-danger text-white'
      },
      buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
      title: $header,
      html: $body,
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Abbrechen',
      confirmButtonText: 'Löschen',
      showLoaderOnConfirm: true,
      reverseButtons: true
    }).then(function (result) {
      if (result.isConfirmed) {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'DELETE',
          url: $url,
          data: {
            _token: token
          },
          success: function success(resp) {
            if (resp.success) {
              Swal.fire('Gelöscht!', 'Der Eintrag wurde erfolgreich gelöscht!<br><br>Das Fenster wird automatisch nach <b>3 Sekunden</b> geschlossen.', 'success');
              setTimeout(function () {
                location.reload();
              }, 3000);
            } else {
              Swal.fire("Fehler!", 'Es ist ein Fehler aufgetreten.', "error");
            }
          },
          error: function error(resp) {
            Swal.fire("Fehler!", 'Es ist ein Fehler aufgetreten.', "error");
          }
        });
      }
    });
  });

  /* *********************************************************************** */

  /*
   *
   */

  $.ajaxSetup({
    async: true,
    cache: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  /* *********************************************************************** */

  /**
   *
   */

  $('body').on('[data-ajax]', 'click', function (event) {
    event.preventDefault();
    var $this = $(this);
    $.ajax({
      url: $this.attr('href'),
      method: 'GET',
      dataType: 'html',
      beforeSend: function beforeSend(xhr) {
        SMM.functions.showLoader('[data-ajax-body="' + $this.data('ajax') + '"]', '<p>Daten werden geladen...</p>');
      }
    }).fail(function (jqXHR, textStatus) {
      toastr.error('Ein unbekannter Fehler ist aufgetreten.<br><br><small>Status: ' + jqXHR.status + '<br>Meldung: ' + jqXHR.statusText + '</small>', {
        "closeButton": true,
        "autohide": false,
        "positionClass": "md-toast-top-right"
      });
      console.log(jqXHR, textStatus);
    }).done(function (html) {
      SMM.functions.hideLoader('[data-ajax-body="' + $this.data('ajax') + '"]', function () {
        $('[data-ajax-body="' + $this.data('ajax') + '"]').html(html);
      });
    });
  });
});
$('body').on('#additional_selection_add', 'click', function (event) {});
})();

/******/ })()
;