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

        function syncTabsWithContent() {
            const linkClass = '.tabs-link';
            const sectionClass = '.tabs-section';

            const makeFirstItemActive = false;
            
            $(".eb-tabs").each(function() {

                var $tabLinks = $(this).find(linkClass);
                var $tabSections = $(this).find(sectionClass);
                
                if($tabLinks.length <= 0 || $tabSections.length <= 0) 
                    return;
                

                for(var i = 0; i < $tabLinks.length; i++) {

                    var currentLink = $tabLinks.eq(i);
                    var currentSection = $tabSections.eq(i);

                    // Get nav ID, if it is undefined, set it to 'navTab' + i
                    var linkId = currentLink.attr('id');
                    if(typeof linkId == 'undefined')
                        linkId = 'tabLink';
                    
                    linkId += '_' + i;

                    
                    // Get pane ID, if it is undefined, set it to 'paneTab' + i
                    var sectionId = currentSection.attr('id');
                    if(typeof sectionId == 'undefined')
                    sectionId = 'tabSection';
                    
                    sectionId += '_' + i;

                    
                    // Set navTab ID and properties 
                    currentLink.attr('id', linkId);
                    currentLink.attr('data-bs-target', '#' + sectionId);
                    currentLink.attr('aria-controls', sectionId);
                    
                    // Set paneTab ID and properties 
                    currentSection.attr('id', sectionId);
                    currentSection.attr('aria-labelledby', linkId);

                    // Set first pane and nav as active
                    if(makeFirstItemActive && i == 0) {
                        $(currentLink).addClass('active');
                        $(currentSection).addClass('active');
                        $(currentSection).addClass('show');
                    }
                }

            });
            
            var url = window.location.href;
            if(!url.includes('#')) return;
            var id = url.substring(url.lastIndexOf('#') + 1);

            var $parent = $('#' + id).parent(linkClass);
            if($parent.length > 0) {
                activeTab = $parent[0];
                contentId = $parent.attr('data-bs-target');
                activeContent = $(contentId);

                $(activeTab).addClass('active');
                $(activeContent).addClass('active');
                $(activeContent).addClass('show');
            }

        }

        /**
         * Invocate functions when document.body is ready 
         */
        $(document.body).ready(function (){
            setSVGViewBox();
            generateCarouselIndicators();
            syncTabsWithContent();
        });
    }
)