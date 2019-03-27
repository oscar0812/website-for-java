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
});
