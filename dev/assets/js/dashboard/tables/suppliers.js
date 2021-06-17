$(document).ready(function () {
  var id =  $('.suppliers_table').attr('id')
   $('.suppliers_table').load('/controllers/tables/supplier/suppliers.php?page='+id,function () {
   });
});