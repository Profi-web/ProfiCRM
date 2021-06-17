$(document).ready(function () {
  var id =  $('.persons_table').attr('id')
   $('.persons_table').load('/controllers/tables/person/persons.php?page='+id,function () {
   });
});