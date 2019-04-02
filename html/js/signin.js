$(function() {
  $('form.form-signin').on('submit', function(e) {
    ajaxForm(e.target, function(data) {
      if (data.success) {
        window.location.href = data.route;
      } else {
        Snackbar.show({
          actionTextColor: "#FF0000",
          text: "Incorrect Email or Password"
        });
      }
    });
    return false;
  });
})
