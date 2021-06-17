$(document).ready(function () {
  var id =  $('.companies_table').attr('id')
   $('.companies_table').load('/controllers/tables/company/companies.php?page='+id,function () {
   });
});