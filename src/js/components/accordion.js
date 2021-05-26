(jQuery)(
    function($) {

        $(document.body).click(function(e) {
            var $elem = $(e.target); 
            var hasClass = $elem.hasClass("accordion-button");
            var $parents = $elem.parents(".accordion-button");

            if(hasClass || $parents.length != 0) {
                var btn = $elem;

                if(!hasClass) {
                    btn = $parents[0]; 
                }
                
                if($(btn).data('toggle') == "collapse") {
                    var target = $(btn).data('target');

                    const delay = 400;

                    if($(target).hasClass('show')) {
                        $(btn).addClass('collapsed');

                        $(target).animate({
                            display: "none",
                            height: "toggle"
                        }, delay, () => {
                            $(target).removeClass('show');
                        });

                    }
                    else {
                        $(btn).removeClass('collapsed');

                        $(target).animate({
                            display: "block",
                            height: "toggle"
                        }, delay, () => {
                            $(target).addClass('show');
                        });

                    }
                }
            }

            // $(".accordion-button").unbind().each(function(i) {
            //     $(this).click(() => {
            //         if($(this).data('toggle') == "collapse") {
            //             var target = $(this).data('target');

            //             const delay = 400;

            //             if($(target).hasClass('show')) {
            //                 $(this).addClass('collapsed');

            //                 $(target).animate({
            //                     display: "none",
            //                     height: "toggle"
            //                 }, delay, () => {
            //                     $(target).removeClass('show');
            //                 });

            //             }
            //             else {
            //                 $(this).removeClass('collapsed');

            //                 $(target).animate({
            //                     display: "block",
            //                     height: "toggle"
            //                 }, delay, () => {
            //                     $(target).addClass('show');
            //                 });

            //             }
            //         }
            //     });
            // });
        });
    }
);