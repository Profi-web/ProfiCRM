<?php
/*Page Info*/
$page = 'KennisPlein';
$type = 'articles';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page']) && $_GET['page'] && $_GET['page'] !== 'null') {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$user = new User();
if (isset($_GET['tag']) && $_GET['tag'] && $_GET['tag'] !== null) {
    $tag = $_GET['tag'];
} else {
    $tag = '';
}

if (isset($_GET['search']) && $_GET['search'] && $_GET['search'] !== null) {
    $search = $_GET['search'];
} else {
    $search = '';
}

$table = new TableArticles($pagination, 'articles', 'bedrijven', $tag, $search);

$tags = new Tags();

//

/*CSS*/


/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->

<div class="container-fluid justify-content-center" style="margin-top:-40px;">
    <div class="row px-3 px-md-5">
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow ">
                <div class="card-header border-0 bg-white rounded-top p-4">
                    <div class="row px-4 align-items-center justify-content-between">
                        <h5 class="mb-0 ">Alle artikelen</h5>

                        <a class="btn btn-info rounded text-white" href="/kennisplein/nieuw">Nieuw artikel</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush mb-0 table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Onderwerp</th>
                            <th scope="col">Tags</th>
                            <th scope="col">Datum</th>
                        </tr>
                        </thead>
                        <tbody class="articles_table" id="<?php echo $table->currentpage; ?>">
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="tags" value="<?php if (isset($_GET['tag']) && $_GET['tag']) {
                    echo $_GET['tag'];
                } ?>">
                <div class="card-footer py-4 bg-white rounded-bottom">
                    <nav aria-label="...">
                        <ul class="pagination justify-content-center justify-content-md-end mb-0">


                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div><i class="fad fa-filter"></i> Filters</div>
                                <a class="btn btn-info rounded text-white btn-sm" id="back_relation" data-toggle="modal" data-target="#exampleModal">Bewerken</a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="font-weight-bold"><i class="fad fa-search"></i> Zoeken</h6>
                            <div class="input-group mb-2 mt-3">
                                <input class="form-control filter_search" type="search" placeholder="Zoeken.."
                                       value="<?php if (isset($_GET['search'])) {
                                           echo $_GET['search'];
                                       } ?>">
                                <div class="input-group-append prepend_search">
                                    <span class="input-group-text"><i class="fad fa-search"></i></span>
                                </div>
                            </div>
                            <hr>
                            <h6 class="font-weight-bold"><i class="fad fa-tags"></i> Tags</h6>
                            <ul class="tags mb-2">
                                <?php
                                foreach ($tags->getTags() as $tag) {
                                    /*IF TAG IS SET*/
                                    if (isset($_GET['tag']) && $_GET['tag']) {
                                        $currenttag = $_GET['tag'];
                                        $upcomingtags = explode(',', $currenttag);

                                        //IF TAG IS IN ARRAY
                                        if (in_array($tag['id'], $upcomingtags)) {
                                            $class = 'font-weight-bold';
                                        } else {
                                            $class = '';
                                        }


                                    } else {
                                        $class = '';

                                    }

                                    ?>
                                    <li><a data-link="<?php echo $tag['id']; ?>"
                                           class="tag_click <?php echo $class; ?>"><?php echo $tag['name']; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tags bewerken</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $article = new Article();

                $article->showAllEditRelations();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>
<div class="bottom_notes">Profi-crm versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script>
    var activeLink = theURL = new URL(window.location.href);

    function getUrl() {
        return new URL(
            window.location.href);
    }

    function getParam(tag, url = null) {
        if (url == null) {
            var url = getUrl();
        }
        return url.searchParams.get(tag);
    }

    function setParam(tag, param, url = null) {
        if (url == null) {
            var url = getUrl();
        }
        url.searchParams.set(tag, param);
        return url;
    }

    function deleteParam(tag, url = null) {
        if (url == null) {
            var url = getUrl();
        }
        url.searchParams.delete(tag);
        return url;
    }


    $(document).ready(function () {
        if (getParam('page')) {
            var pagefirst = getParam('page');
        } else {
            var pagefirst = 1;
        }

        if (getParam('tag')) {
            var tagfirst = '&tag=' + getParam('tag');
        } else {
            var tagfirst = '';
        }

        if (getParam('search')) {
            var searchfirst = '&search=' + getParam('search');
        } else {
            var searchfirst = '';
        }


        $('.pagination').load('/controllers/tables/articles/articles_pagination.php?page=' + pagefirst + tagfirst + searchfirst, function () {
        });

        /*SET TABLE ID*/
        var id = $('.articles_table').attr('id');
        /*SAVE TAGS*/
        /*ON LOAD*/

        $('.articles_table').load('/controllers/tables/articles/articles.php?page=' + pagefirst + tagfirst + searchfirst, function () {
        });


        /*ON A TAG CLICK*/
        $('.tag_click').on('click', function () {


            //Save currentTag item
            var currentTag = $(this);
            //Get item id
            var itemID = $(this).data('link');
            if (getParam('tag')) {
                var getParamsArray = getParam('tag').split(',').map(Number);
                var url = getUrl();
                if (getParamsArray.includes(parseInt(itemID))) {
                    var index = getParamsArray.indexOf(parseInt(itemID));
                    if (index > -1) {
                        getParamsArray.splice(index, 1);
                    }
                    if (getParamsArray.length) {
                        setParam('tag', getParamsArray.join(','), url);
                    } else {
                        deleteParam('tag', url);
                    }

                    $.ajax({
                        method: 'get',
                        url: '/controllers/tables/articles/articles_getPages.php' + url.search,
                        success: function (data) {
                            data = JSON.parse(data);
                            var totalPages = data.pages;
                            var currentPages = getParam('page', url);
                            if (currentPages > totalPages) {
                                url = setParam('page', totalPages);
                            }

                            $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
                            });

                            $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
                            });
                            window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);

                        }
                    });
                    currentTag.removeClass('font-weight-bold');
                } else {
                    currentTag.addClass('font-weight-bold');
                    var url = getUrl();
                    var params = getParam('tag') + ',' + itemID;
                    url = setParam('tag', params.split(','));
                    $.ajax({
                        method: 'get',
                        url: '/controllers/tables/articles/articles_getPages.php' + url.search,
                        success: function (data) {
                            data = JSON.parse(data);
                            var totalPages = data.pages;
                            var currentPages = getParam('page', url);
                            if (currentPages > totalPages) {
                                url = setParam('page', totalPages);
                            }

                            $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
                            });

                            $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
                            });
                            window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);

                        }
                    });
                }
            } else {
                currentTag.addClass('font-weight-bold');
                var url = getUrl();
                url = setParam('tag', itemID.toString());
                $.ajax({
                    method: 'get',
                    url: '/controllers/tables/articles/articles_getPages.php' + url.search,
                    success: function (data) {
                        data = JSON.parse(data);
                        var totalPages = data.pages;
                        var currentPages = getParam('page', url);
                        if (currentPages > totalPages) {
                            url = setParam('page', totalPages, url);
                        }

                        $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
                        });

                        $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
                        });
                        window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);

                    }
                });


            }


        });


        $('.prepend_search').on('click', function () {
            search();
        });

        $('.filter_search').keyup(function (e) {
            if (e.keyCode === 13) {
                search();
            }
        });


        function search() {
            var url = getUrl();
            //Save currentSearch item
            var currentTag = $('.filter_search');
            //Get search value
            $('.filter_search').removeClass('is-invalid');
            var itemID = $('.filter_search').val();
            if (getParam('search')) {

                if (itemID) {
                    ;
                    url = setParam('search', itemID.toString());
                } else {
                    url = deleteParam('search');
                }
                $.ajax({
                    method: 'get',
                    url: '/controllers/tables/articles/articles_getPages.php' + url.search,
                    success: function (data) {
                        data = JSON.parse(data);
                        // var totalPages = data.pages;
                        // var currentPages = getParam('page', url);
                        // if (currentPages > totalPages) {
                        url = setParam('page', 1,url);
                        // }

                        $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
                        });

                        $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
                        });
                        window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);

                    }
                });

            } else {
                if (itemID) {
                    url = setParam('search', itemID.toString());
                } else {
                    url = deleteParam('search');
                }
                $.ajax({
                    method: 'get',
                    url: '/controllers/tables/articles/articles_getPages.php' + url.search,
                    success: function (data) {
                        data = JSON.parse(data);
                        // var totalPages = data.pages;
                        // var currentPages = getParam('page', url);
                        // if (currentPages > totalPages) {
                        url = setParam('page', 1,url);
                        // }

                        $('.articles_table').load('/controllers/tables/articles/articles.php' + url.search, function () {
                        });

                        $('.pagination').load('/controllers/tables/articles/articles_pagination.php' + url.search, function () {
                        });
                        window.history.pushState("null", "Kennisplein", "/kennisplein" + url.search);

                    }
                });


            }

        }
        alertify.defaults.transition = "fade";
        alertify.defaults.theme.ok = "btn btn-info btn-sm rounded";
        alertify.defaults.theme.cancel = "btn btn-danger btn-sm rounded";
        alertify.defaults.theme.input = "form-control";
        alertify.defaults.glossary.ok = "Oke";
        alertify.defaults.glossary.cancel = "Annuleren";
        $('.deleteTag').on('click', function (event) {
            var current = $(this);
            event.preventDefault();
            alertify.confirm('Verwijderen',"Weet je zeker dat je deze tag wilt verwijderen?",
                function(){
                    $.ajax({ //Process the form using $.ajax()
                        type: 'POST', //Method type
                        url: '/controllers/tables/articles/articles_tags_delete_single.php', //Your form processing file URL
                        data: {
                            id: current.attr('id'),
                        }
                        , //Forms name
                        success: function (data) {
                            data = JSON.parse(data);

                            if (data.status === 'success') {
                              window.location.reload();
                            } else {
                                $(".alert_field_relation").load("/controllers/error.php", {
                                    message: data.message,
                                    class: data.class
                                }, function () {

                                    $('.alert').fadeIn(1000);
                                });
                            }
                        }
                    });
                },
                function(){
                });

        });
    });

</script>
