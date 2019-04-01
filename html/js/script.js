function ajaxForm(form, callback) {
  var data = new FormData(form);
  $.ajax({
    url: form.action,
    method: form.method,
    processData: false,
    contentType: false,
    data: data,
    processData: false,
    success: callback
  });
}

$(function() {
  $("#sortable").sortable({
    handle: '.fa-arrows',
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

  $('[data-target="#newSceneModal"]').on('click', function() {
    // new scene modal button clicked (load the traps and items)
    btn = $(this);
    items = $('[name="item_choice"]');
    traps = $('[name="trap_choice"]');

    $.ajax({
      url: btn.attr('data-url'),
      method: 'post',
      success: function(data) {
        items.children().remove();
        traps.children().remove();

        $.each(data['items'], function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);
          items.append(o);
        });

        $.each(data['traps'], function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);
          traps.append(o);
        });
      }
    });
  });

  $('div.modal form').on('submit', function(e) {
    $(e.target).attr('action', $('body').data('form-url')).attr('method', 'POST');

    ajaxForm(e.target, function(data) {
      console.log(data);
    });
    return false;
  });

  // search in navbar
  prevTxt = "";
  $('nav .form-inline input').on('input keyup', function() {
    txt = $(this).val();
    if (txt == prevTxt) {
      return false;
    }
    prevTxt = txt;
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
