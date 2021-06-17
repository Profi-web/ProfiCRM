$(document).ready(function () {
  var id =  $('.users_table').attr('id')
   $('.users_table').load('/controllers/tables/user/users.php?page='+id,function () {
   });
});