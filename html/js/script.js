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

  toggle = $('#switch');
  toggle.on('change', function() {
    if (!toggle.prop("checked")) {
      $('#sortable li').css('background-color', 'white');
    }
  })
  // when li is hovered

  $('#sortable li').hover(function(e) {
    isChecked = toggle.prop("checked");
    if (isChecked) {
      // clear out previous colors
      $('#sortable li').css('background-color', 'white');
      // show all the parents in green, and children in red
      id = $(this).attr('data-id');
      // set the children to red
      children = $('#sortable li[data-parent-id="' + id + '"]');
      children.css('background-color', '#f48fb1');

      pId = $(this).attr('data-parent-id');
      parents = $('#sortable li[data-id="' + pId + '"]');
      parents.css('background-color', '#69f0ae');

      $(this).css('background-color', '#e0e0e0');
    }
  });

  function loadValues(id) {
    items = $('[name="item_choice"]');
    traps = $('[name="trap_choice"]');
    parents = $('[name="parent_choice"]');

    url = id == 0 ? $('body').attr('data-json') : $('body').attr('data-scene-info');
    method = id == 0 ? "get" : "post";

    $.ajax({
      url: url,
      method: method,
      data: {
        id: id
      },
      success: function(data) {
        info = id == 0 ? data : data.info;
        desc = id == 0 ? "" : data.scene.Description;
        itemId = id == 0 ? -1 : data.scene.ItemId;
        trapId = id == 0 ? -1 : data.scene.TrapId;
        parentId = id == 0 ? -1 : data.scene.ParentSceneId;

        items.children().remove();
        traps.children().remove();
        parents.children().not('[value="0"]').remove();

        // append the data onto dropdowns
        $.each(info.items, function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);

          if (v.Id == itemId) {
            o.attr('selected', true);
          }

          items.append(o);
        });

        $.each(info.traps, function(i, v) {
          o = $('<option>').text(v.Name).attr('value', v.Id);

          if (v.Id == trapId) {
            o.attr('selected', true);
          }

          traps.append(o);
        });

        $.each(info.scenes, function(i, v) {
          o = $('<option>').text(v.Description).attr('value', v.Id);

          if (v.Id == parentId) {
            o.attr('selected', true);
          }

          parents.append(o);
        });

        // set the description
        $('#editSceneModal textarea').val(desc);
      }
    });
  }

  // new scene modal button clicked (load the traps, items, and scenes)
  $('[data-target="#newSceneModal"]').on('click', function() {
    loadValues(0);
  });

  $('#sortable [data-target="#editSceneModal"]').on('click', function() {
    li = $(this).closest('li');
    id = li.attr('data-id');
    // set the id
    $('#editSceneModal').find('input[name="scene_id"]').val(id);

    loadValues(id);
  });

  $('div.modal form').on('submit', function(e) {
    $(e.target).attr('action', $('body').data('form-url')).attr('method', 'POST');

    ajaxForm(e.target, function(data) {
      console.log(data);
      msg = "";
      if (data.params.type == 'scene') {
        sortable = $('#sortable');

        // adding, not editing
        if (typeof data.params.scene_id == 'undefined') {

          invisible = sortable.find('.invisible');
          template = invisible.clone().removeClass('invisible');
          template.attr('data-id', data.params.id);
          template.attr('data-parent-id', data.params.parent_choice);
          template.find('.scene-id').text(data.params.id);
          template.find('.scene-description').text(data.params.description);

          invisible.after(template);

          msg = "Added Scene Successfully";
        } else {
          // editing, not adding
          li = $('li[data-id="' + data.params.scene_id + '"]').eq(0);
          li.find('.scene-description').text(data.params.description);
          li.attr('data-parent-id', data.params.parent_choice);
          msg = "Edited Scene Successfully";
        }
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
