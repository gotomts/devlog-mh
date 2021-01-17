$(function(){
  var $logoutBtn  = $('.logout-btn');
  var $logoutForm = $('#logout-form');
  // ログアウトフォームをsubmit
  $logoutBtn.on('click', function(e){
    e.preventDefault();
    $logoutForm.submit();
  });
});
