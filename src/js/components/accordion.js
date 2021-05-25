(jQuery)(
    function($) {

        $(document.body).ready(function() {

            $(".accordion-button").each(function(i) {
                $(this).click(() => {
                    if($(this).data('toggle') == "collapse") {
                        var target = $(this).data('target');

                        const delay = 400;

                        if($(target).hasClass('show')) {
                            $(this).addClass('collapsed');

                            $(target).animate({
                                display: "none",
                                height: "toggle"
                            }, delay, () => {
                                $(target).removeClass('show');
                            });

                        }
                        else {
                            $(this).removeClass('collapsed');

                            $(target).animate({
                                display: "block",
                                height: "toggle"
                            }, delay, () => {
                                $(target).addClass('show');
                            });

                        }
                    }
                });
            });
        });
    }
);