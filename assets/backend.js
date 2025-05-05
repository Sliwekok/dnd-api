const checkNav = $('#admin-header');
if (checkNav) {
    setTimeout(() => {
        let flashMessages = $('.flash-message');
        if (flashMessages.length) {
            flashMessages.each(function () {
                let message = $(this);
                message.fadeIn(500).delay(10000).fadeOut(500, function () {
                    message.remove();
                });
            });
        }
    });
}
