/** 
 * Front-end scripts
 * 
 * @package Emertech Blocks Plugin
 */

(jQuery)(
    function($) {

        /**
         * Set SVG view box to clear white space 
         * 
         * @since 1.0
         */
        function setSVGViewBox() {
            // Get all SVG objects in the DOM
            var svgs = document.getElementsByTagName("svg");

            // Go through each one and add a viewbox that ensures all children are visible
            for (var i=0, l=svgs.length; i<l; i++) {

                var svg = svgs[i],
                    box = svg.getBBox(), // Get the visual boundary required to view all children
                    viewBox = [box.x, box.y, box.width, box.height].join(" ");

                // Set viewable area based on value above
                svg.setAttribute("viewBox", viewBox);
            }
        }

        /**
         * Generate .carousel-indicators buttons for each .carousel
         * 
         * @since 2.0
         */
        function generateCarouselIndicators() {
            $(".carousel").each(function() {
                // Don't generate indicatos if it already has them 
                // OR if it has them disabled 
                if($(this).find(".carousel-indicators") 
                || $(this).attr("data-emertech-indicators" == "false")) 
                    return;

                var $items = $(this).find(".carousel-item");

                var carouselId = $(this).attr("id");

                var indicators = '<div class="carousel-indicators">';

                for (var i = 0; i < $items.length; i++) {
                    var item = $items[i];
                    var isFirst = !$(item).hasClass("active") && i == 0;

                    var activeClass = (isFirst) ? "active" : "";
                    var ariaLabel = "Slide " + (i+1);
                    var indicator = '<button';
                    indicator += ' type="button"';
                    indicator += ' data-bs-slide-to="' + i + '"'; 
                    indicator += ' data-bs-target="#' + carouselId + '"'; 
                    indicator += ' aria-label="' + ariaLabel + '"'; 
                    indicator += ' aria-current="true"'; 
                    indicator += ' class="' + activeClass + '"';
                    indicator += '></button>';
                    $(item).addClass(activeClass);

                    indicators += indicator;
                }

                indicators += '</div>';

                console.log(indicators);

                $(this).append(indicators);
            })
        }

        /**
         * Invocate functions when document.body is ready 
         */
        $(document.body).ready(function (){
            setSVGViewBox();
            generateCarouselIndicators();
        });
    }
)