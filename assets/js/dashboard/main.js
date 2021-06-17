/*SEARCH*/

$('.search_area').on('click', function (event) {
    event.stopPropagation();
    $('.profile_box').hide();
    $('.profile_box_mobile').hide();
    $('.search_box').show();

    $('.search_area input').on("keyup input", function(){
        var defaultInput0 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';
        var defaultInput1 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ minimaal 2 tekens om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';

        var inputVal = $('.search_area input').val();
        var resultDropdown = $('.search_box .result');
        if(inputVal.length >= 2){
            $.get("/controllers/search/desktop.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else if(inputVal.length = 1){
            resultDropdown.html(defaultInput1);
        } else {
            resultDropdown.html(defaultInput0);
        }
    });
});
$('.mobile_search').on('click', function (event) {
    event.stopPropagation();
    $('.mobile_search_box').show();

    $('.mobile_search_area input').on("keyup input", function(){
        var defaultInput0 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';
        var defaultInput1 = '<div class="col-12 py-2 px-4 search_item muted">\n' +
            '                                                <a class="row align-items-center">\n' +
            '                                                    <i class="fad fa-search text-primary search_icon"></i>\n' +
            '                                                    <div class="pl-2 search_text">Typ minimaal 2 tekens om te zoeken</div>' +
            '                                                </a>\n' +
            '                                            </div>';

        var inputVal = $('.mobile_search_area input').val();
        var resultDropdown = $('.mobile_search_area .mobile_search_box');
        if(inputVal.length >= 2){

            $.get("/controllers/search/desktop.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else if(inputVal.length = 1){
            resultDropdown.html(defaultInput1);
        } else {
            resultDropdown.html(defaultInput0);
        }
    });
});

/************/



/*PROFILE*/

$('.profile').on('click', function (event) {
    event.stopPropagation();
    $('.search_box').hide();
    $('.profile_box').show();
});
$('.profile_mobile').on('click', function (event) {
    event.stopPropagation();
    $('.profile_box_mobile').show();
});

/************/



/*WINDOW*/

$(window).click(function () {
    /*PROFILE*/
    $('.profile_box').hide();
    $('.profile_box_mobile').hide();
    /**/

    /*SEARCH*/
    $('.mobile_search_box').hide();
    $('.search_box').hide();
    /**/
});

