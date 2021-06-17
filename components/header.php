<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <script defer src="/assets/js/fa/all.js"></script> <!--load all styles --><!--    <script src="https://kit.fontawesome.com/bcb85cce6e.js" crossorigin="anonymous"></script>-->
    <link rel="icon" href="/assets/media/favicon.png" sizes="16x16" type="image/png">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <title>Profi-CRM | Client System</title>
</head>
<?php if (!empty($gradient)) {
    if ($gradient) {
        $class = 'gradient';
    } else {
        $class = '';
    }
} else {
    $class = '';
}
$usertheme = new User();
if($usertheme) {
    if ($usertheme->data && $usertheme->data['theme'] == 2) {
        ?>
        <style>
            .bg-white, .card, .table .thead-light th,
            .bg-dark, .sidenav_menu .item .text, .search_box, .notification_top, .profile_box, .list-group-item {
                background: #2f2f30 !important;
            }

            .notification_icon {
                background: #c6c6cc !important;
            }

            .table th, .table td, .list-group-item {
                border-color: #5e5e5e !important;
            }

            body div div.card-footer {
                border-top: 1px solid #5e5e5e !important;
            }

            .search_box .search_item:hover,
            .work_table_tr:hover {
                background: #373738 !important;
            }

            body, .notification_content, body .bg-light-second, .custom-file-label, #profile_image, .page-link, .users_table .current, .modal-content, .bg-light, .custom-file-label::after {
                background: #323233 !important;
            }

            .prospect_top {
                background: #2f2f30;
                border-top: 1px solid #5e5e5e
            }

            #company_info .bg-white, .tox .tox-statusbar, .tox .tox-toolbar,
            .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary, .form-control, .input-group-text, .tox .tox-edit-area__iframe {
                background: #353536 !important;
            }

            .search_area .form-control,
            .search_area .input-group-text {
                background: transparent !important;
            }

            body, .bg-dark, .input-group-text, .sidenav_menu .item .text, .search_text, .form-control, .profile_box li a,
            .page-link, .tox, .tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary.tox .tox-edit-area, .custom-select, #tinymce, .tox .tox-edit-area__iframe #tinymce, .mce-content-body {
                color: white !important;
            }

            .tox .tox-tbtn svg {
                fill: white !important;
            }

            .text-muted {
                color: #e9e9e9 !important;
            }

            .divider {
                border-color: #e9e9e9 !important;
            }
        </style>
        <?php
    }
}
?>
<body class="<?php echo $class; ?>">
