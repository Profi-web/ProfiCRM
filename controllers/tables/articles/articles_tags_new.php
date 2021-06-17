<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /404');
}
/**/

$article = new Article($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();
//
?>
<form class="p-0 m-0" id="person_contact_form" novalidate>
    <div class="card-header border-0 bg-light-second rounded-top p-3">
        <div class="row px-4 align-items-center justify-content-between">
            <div>Tags</div>
            <a class="btn btn-dark rounded text-white btn-sm" id="back_relation">Terug</a>
        </div>
    </div>
    <div class="container-fluid px-4 py-2 rounded-bottom rounded-top">
        <div class="alert_field_relations pt-2">
        </div>
        <div class="row">
            <div class="col-12 ">
                <div class="container-fluid">
                    <div class="row relations_edit mb-2">

                            <label for="selectedChoice" class="pt-2">
                                Kies een bestaande tag
                            </label>
                            <div class="input-group mb-3">
                                <select class="custom-select rounded" id="selectedChoice" data-style="btn-new">
                                    <option selected disabled>Keuze...</option>
                                        <?php
                                        $article->showOptions($id);
                                        ?>
                                </select>
                                <div id="selectedRemove" ><div class="h-100 d-flex align-items-center px-2"><i class="fad fa-times"></i></div></div>
                            </div>

                        <label for="selectedChoice" class="pt-2">
                           Maak een nieuwe tag
                        </label>
                        <div class="input-group mb-3">
                           <input class="form-control rounded" type="text" name="newTag" placeholder="Tag naam" id="newTag"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row px-4 justify-content-end">
            <a class="btn btn-success btn-sm text-white rounded save_relation"
               id="<?php echo $article->getData('id'); ?>">Toevoegen</a>
        </div>

    </div>
</form>
<script>
    $('#back_relation').on('click', function (event) {
        $('#article_tags').load('/controllers/tables/articles/articles_tags.php?id=<?php echo $article->getData('id') ?>', function () {
        });
    });
    $('#selectedChoice ').on('change', function () {
        if($('#selectedChoice option:selected[value!=""]').length ) {
            $('#selectedRemove').show();
        }
    });
    $("#selectedRemove").on('click',function () {
        $('#selectedChoice').prop('selectedIndex',0);
        $('#selectedRemove').hide();
    });
    $('.save_relation').on('click', function () {
      if($("#selectedChoice").val()){
          if(!$("#newTag").val()){
              if(
                  $('.save_relation').attr('id') === null ||
                  $('.save_relation').attr('id') === undefined ||
                  $('.save_relation').attr('id') === '' ||


                  $('#selectedChoice').val() === null ||
                  $('#selectedChoice').val() === undefined ||
                  $('#selectedChoice').val() === ''
              ){
                  $(".alert_field_relations").load("/controllers/error.php", {
                      message: 'Maak aub een keuze',
                      class: 'alert-danger'
                  }, function () {

                      $('.alert').fadeIn(1000);
                  });
              } else {
                  $.ajax({ //Process the form using $.ajax()
                      type: 'POST', //Method type
                      url: '/controllers/tables/articles/articles_tags_save.php', //Your form processing file URL
                      data: {
                          tag: $('.save_relation').attr('id'),
                          choice: $('#selectedChoice').val(),
                      }
                      , //Forms name
                      success: function (data) {
                          data = JSON.parse(data);

                          if (data.status === 'success') {
                              $('#article_tags').load('/controllers/tables/articles/articles_tags.php?id=<?php echo $article->getData('id') ?>', function () {
                              });
                          } else {
                              $(".alert_field_relations").load("/controllers/error.php", {
                                  message: data.message,
                                  class: data.class
                              }, function () {

                                  $('.alert').fadeIn(1000);
                              });
                          }
                      }
                  });
              }
          } else {
              $(".alert_field_relations").load("/controllers/error.php", {
                  message: 'Je kan geen bestaande tag & nieuwe tegelijk toevoegen',
                  class: 'alert-danger'
              }, function () {

                  $('.alert').fadeIn(1000);
              });
          }
      } else {
          if($("#newTag").val()){
              $.ajax({ //Process the form using $.ajax()
                  type: 'POST', //Method type
                  url: '/controllers/tables/articles/articles_tags_save_new.php', //Your form processing file URL
                  data: {
                      tag: $('.save_relation').attr('id'),
                      choice: $('#newTag').val(),
                  }
                  , //Forms name
                  success: function (data) {
                      data = JSON.parse(data);

                      if (data.status === 'success') {
                          $('#article_tags').load('/controllers/tables/articles/articles_tags.php?id=<?php echo $article->getData('id') ?>', function () {
                          });
                      } else {
                          $(".alert_field_relations").load("/controllers/error.php", {
                              message: data.message,
                              class: data.class
                          }, function () {

                              $('.alert').fadeIn(1000);
                          });
                      }
                  }
              });
          } else {
              $(".alert_field_relations").load("/controllers/error.php", {
                  message: 'Je hebt geen bestaande of nieuwe toegevoegd',
                  class: 'alert-danger'
              }, function () {

                  $('.alert').fadeIn(1000);
              });
          }
      }
    });

</script>
