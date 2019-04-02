$(function(){
  $('form.form-signin').on('submit', function(e){
    ajaxForm(e.target, function(data){
      console.log(data);
    });
    return false;
  });
})
