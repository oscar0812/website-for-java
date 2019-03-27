$(function() {
  $("#sortable").sortable({
    update: function(item, ui) {
      item = $(ui.item);

      // make the call
      $.ajax({
        url: item.closest("ul").attr('data-url'),
        method: 'post',
        data: {
          id: item.attr('data-id'),
          new_index: item.index() + 1
        },
        success: function(data) {
          console.log(data);
        }
      });
    }
  });


  /*

  Snackbar.show({
    actionTextColor: '#00FF00',
    text: "Updated"
  });

  */

  //----- OPEN
  $('[pd-popup-open]').on('click', function(e) {
    var targeted_popup_class = $(this).attr('pd-popup-open');
    popup = $('[pd-popup="' + targeted_popup_class + '"]');
    popup.removeClass('invisible');
    popup.fadeIn(100);


    e.preventDefault();
  });

  //----- CLOSE
  $('[pd-popup-close]').on('click', function(e) {
    var targeted_popup_class = $(this).attr('pd-popup-close');
    popup = $('[pd-popup="' + targeted_popup_class + '"]');
    popup.fadeOut(100, function() {
      popup.addClass('invisible');
    });

    e.preventDefault();
  });

  $('nav .form-inline input').on('input keyup', function() {
    txt = $(this).val();
    console.log(txt);

    $('.list-group-item').each(function() {
      if ($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });

    return false;
  })
});
