/**
 * Accordion scripts to animate show and collapse 
 * 
 * @package Emertech Blocks Plugin
 */

(jQuery)(
    function($) {

        /**
         * Toggle accordion according to document.body click
         * 
         * @since 2.0
         */
        toggleAccordion = (e) => {
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
        }
        
        /** 
         * Bind document.body click event to toggleAccordion function
         * 
         * @since 2.0
         */
        $(document.body).click(toggleAccordion);
    }
);