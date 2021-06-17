$('.notification_icon ').on('click', function () {
    if ($('.notification_board').hasClass('d-block')) {
        $('.notification_board').removeClass('d-block');
    } else {
        $('.notification_board').addClass('d-block');
    }
});

$('.close_notification').on('click',function () {
    $('.notification_board').removeClass('d-block');
});
