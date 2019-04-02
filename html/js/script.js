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
          new_index: item.index()
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

  // when li is hovered
  toggle = $('#switch');
  $('#sortable li').hover(function(e) {
    isChecked = toggle.prop("checked");
    if (isChecked) {
      // clear out previous colors
      $('#sortable li').css('background-color', 'white');
      // show all the parents in green, and children in red
      id = $(this).attr('data-id');
      // set the children to red
      children = $('#sortable li[data-parent-id="'+id+'"]');
      children.css('background-color', '#f48fb1');

      pId = $(this).attr('data-parent-id');
      parents = $('#sortable li[data-id="'+pId+'"]');
      parents.css('background-color', '#69f0ae');
    }
  });

  $('[data-target="#newSceneModal"]').on('click', function() {
    // new scene modal button clicked (load the traps and items)
    btn = $(this);
    items = $('[name="item_choice"]');
    traps = $('[name="trap_choice"]');
    parents = $('[name="parent_choice"]');

    $.ajax({
      url: btn.attr('data-url'),
      method: 'get',
      success: function(data) {
        console.log(data);
        items.children().remove();
        traps.children().remove();
        parents.children().not('[value="0"]').remove();

        // append the data onto dropdowns
        $.each(data.items, function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);
          items.append(o);
        });

        $.each(data.traps, function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);
          traps.append(o);
        });

        $.each(data.scenes, function(i, v) {
          o = $('<option>').text(v.Description).attr('value', v.Id);
          parents.append(o);
        });
      }
    });
  });

  $('div.modal form').on('submit', function(e) {
    $(e.target).attr('action', $('body').data('form-url')).attr('method', 'POST');

    ajaxForm(e.target, function(data) {
      console.log(data);
      msg = "";
      if (data.params.type == 'scene') {
        sortable = $('#sortable');

        invisible = sortable.find('.invisible');
        template = invisible.clone().removeClass('invisible');
        template.attr('data-id', data.params.id);
        template.attr('data-parent-id', data.params.parent_choice);
        template.find('.scene-id').text(data.params.id);
        template.find('.scene-description').text(data.params.description);

        invisible.after(template);

        msg = "Added Scene Successfully";
      } else if (data.params.type == 'item') {
        msg = "Added Item Successfully";
      } else if (data.params.type == 'trap') {
        msg = "Added Trap Successfully";
      }

      Snackbar.show({
        actionTextColor: '#00FF00',
        text: msg
      });
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
