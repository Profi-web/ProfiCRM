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
$files = new Files(null, 'company_files');
$company = new Company($id);


$loginValidate = new validateLogin();
$loginValidate->securityCheck();


function bytesConvert($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

function fileIcon($type)
{
    switch ($type) {
        case 'pdf':
            return 'file-pdf';
        case 'jpg':
            return 'file-image';
        case 'png':
            return 'file-image';
        case 'txt':
            return 'file-alt';
        default:
            return 'question-square';
    }

}

//
?>
<div class="card-header border-0 bg-white rounded-top p-4">
    <div class="row px-4 align-items-center justify-content-between">
        <h5 class="mb-0 ">Bestanden <span class="text-muted" style="font-size:12pggiox;">Alleen JPG, PNG, en PDF</span></h5>
        <form id="fileUpload">
            <div class="container-fluid">
                <div class="row">
                    <div id="loadingIcon">
                        <img src="/assets/media/bun.gif" class="spinner" width="30px" height="30px">
                    </div>
                    <i class="fas fa-upload pr-1 py-1 text-info fahover" style="font-size:23px" id="uploadIcon"></i>
                    <div class="position-relative">
                        <span class="file-msg js-set-number"></span>
                        <span class=" fileButton btn btn-info rounded text-white btn-sm">Uploaden</span>
                        <input class="file-input" type="file" name="file" multiple accept=".pdf,.png,.jpg">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container-fluid  bg-light-second py-3 rounded-bottom">
    <div class="row p-3">
        <?php
        if ($files->findCompany($id)) {
            foreach ($files->findCompany($id) as $file) {
                ?>
                <div class="col-6 col-md-4 col-lg-3 py-3">
                    <div class="bg-white rounded p-3 ">
                        <div class="row">
                            <div class="col-12 text-center py-2 openFile" data-model="modal<?php echo $file['id']; ?>">
                                <i class="fad fa-<?php echo fileIcon($file['type']); ?> fa-4x text-danger"></i>
                            </div>
                            <div class="col-12 text-center"><?php echo $file['file_name']; ?></div>
                            <div class="col-12 text-center text-muted" style="font-size:13px;">
                                (<?php echo bytesConvert($file['file_size']); ?>)
                            </div>
                            <div class="col-12 text-center pt-2 ">
                                <i class="fad fa-trash-alt p-1 file_trash" data-file="<?php echo $file['id']; ?>"></i>
                                <i class="fad fa-download p-1 file_download" data-relation="<?php echo $file["id"]; ?>"
                                   data-path="<?php echo $file["file_name"]; ?>"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal<?php echo $file['id']; ?>" tabindex="-1" role="dialog"
                     aria-labelledby="modal<?php echo $file['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content rounded">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $file['file_name']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                if ($file['type'] == 'png' || $file['type'] == 'jpg') {
                                    ?>
                                    <img src="/uploads/company/<?php echo $id; ?>/<?php echo $file['file_name']; ?>"
                                         class="w-100">
                                    <?php

                                }
                                ?>
                                <?php
                                if ($file['type'] == 'pdf') {
                                    ?>
                                    <embed src="/uploads/company/<?php echo $id; ?>/<?php echo $file['file_name']; ?>"
                                           width="100%" height="700"
                                           type="application/pdf">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="modal-footer justify-content-center">

                                <p class="text-muted"><i
                                            class="fad fa-file"></i> <?php echo bytesConvert($file['file_size']); ?> |
                                    <i class="fad fa-calendar-alt"></i> <?php
                                    $date = strtotime($file['date']);
                                    $date = date('d-m-Y', $date);

                                    echo $date; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            for ($i = 0; $i < 1; $i++) {
                ?>
                <div class="col-12">
                    <div class="bg-white rounded p-3 ">
                        <div class="row">
                            <div class="col-12 text-muted">
                                Geen bestanden gevonden
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>
</div>
<iframe id="my_iframe" style="display:none;"></iframe>
<script>
    function Download(url) {
        document.getElementById('my_iframe').src = url;
    };
</script>
<script>


    $('.file_download').on('click', function () {
        $path = $(this).data('path');

        fetch('/uploads/company/<?php echo $id;?>/'+$path)
            .then(resp => resp.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = $path;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(() => alert('oh no!'));
    });
    alertify.defaults.transition = "fade";
    alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
    alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
    alertify.defaults.theme.input = "form-control";
    alertify.defaults.glossary.ok = "Oke";
    alertify.defaults.glossary.cancel = "Annuleren";

    $('.file_trash').on('click', function () {
        var id = $(this).data('file');
        alertify.confirm('Verwijderen', "Weet je zeker dat je dit bestand wilt verwijderen?",
            function () {
                $.ajax({ //Process the form using $.ajax()
                    type: 'POST', //Method type
                    url: '/controllers/tables/company/company_file_delete.php', //Your form processing file URL
                    data: {'id': id}, //Forms name
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.status === 'success') {
                            $('#company_files').load('/controllers/tables/company/company_files.php?id=<?php echo $_GET['id'];?>', function () {
                            });
                        }
                    }
                });
            },
            function () {
            });
    });

    $(".openFile").on('click', function () {
        $('#' + $(this).data('model')).modal('show');
    });
    var modals = []
    var fileinput = $(".file-input");
    var jssetnumber = $('.js-set-number');
    var $loading = $('#loadingIcon').hide();
    $('#uploadIcon').on('click', function () {
        if (fileinput.val()) {
            var formData = new FormData();
            formData.append('relation', '<?php echo $_GET['id'];?>');
            [].forEach.call($('.file-input')[0].files, function (file) {
                formData.append('filename[]', file);
            });
            $.ajax({
                url: '/controllers/tables/company/company_save_file.php',
                data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                beforeSend: function () {
                    fileinput.val('');
                    $loading.show();
                    $("#loaderDiv").show();
                    $('#uploadIcon').hide();
                },
                complete: function () {
                    $loading.hide();
                },
                success: function (data) {
                    data = JSON.parse(data);

                    if (data.status === 'success') {
                        $("#loaderDiv").hide();
                        jssetnumber.html(data.message);
                        $('#company_files').load('/controllers/tables/company/company_files.php?id=<?php echo $_GET['id'];?>', function () {
                        });

                    }
                    if (data.status === 'error') {
                        $("#loaderDiv").hide();
                        $('#uploadIcon').show();
                        jssetnumber.html(data.message);
                    }

                },
                error: function (data) {
                    jssetnumber.html('Oeps er ging iets mis!');
                }
            });
        }
    });
    $('.trigger_info').on('click', function () {
        $('#company_info').load('/controllers/tables/company/company_info.php?id=<?php echo $id; ?>', function () {
        });
    });

    // change inner text
    fileinput.on('change', function () {
        var error = '';
        var count = fileinput.prop('files').length;
        var files = fileinput.prop('files');
        if (count > 0) {
            for (i = 0; i < count; i++) {
                var fileExt = files[i]['name'].split('.').pop();
                var fileSize = files[i]['size'];
                var allowedFiles = [
                    'png',
                    'jpg',
                    'svg',
                    'rar',
                    'psd',
                    'txt',
                    'pdf'
                ];
                if (!allowedFiles.includes(fileExt)) {
                    error = error + '<span class="text-danger">Oeps dit is geen geldig bestandextensie</span> <br>';
                }

                if (fileSize > 10000000) {
                    error = error + '<span class="text-danger">Oeps dit bestand is te groot!</span> <br>';
                }
            }
            if (error) {
                jssetnumber.html(error);
                $('#uploadIcon').hide();
            } else {
                $('#uploadIcon').show();
                if (count === 1) {
                    // if single file then show file name
                    jssetnumber.text(fileinput.val().split('\\').pop());
                } else {
                    // otherwise show number of files
                    jssetnumber.text(count + ' bestanden geselecteerd');
                }
            }
        } else {
            $('#uploadIcon').hide();
        }
    });
</script>
<style>
    .file-msg {
        font-size: small;
        font-weight: 300;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: middle;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
    }

    .file-input:focus {
        outline: none;
    }
</style>
