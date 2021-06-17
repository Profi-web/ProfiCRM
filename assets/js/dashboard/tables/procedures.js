$(document).ready(function () {
  var id =  $('.procedures_table').attr('id')
   $('.procedures_table').load('/controllers/tables/procedure/procedures.php?page='+id,function () {
   });
});