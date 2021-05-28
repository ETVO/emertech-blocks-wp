<?php

function render_block_carousel($attributes, $content)
{
    $block_id = $attributes["blockId"];
    if(empty($block_id)) $block_id = "eb-carousel-" . rand(0, 999);

    $show_indicators = $attributes["showIndicators"];
    if(empty($show_indicators)) $show_indicators = false;

    $show_controls = $attributes["showControls"];
    if(empty($show_controls)) $show_controls = false;

    $auto_slide = $attributes["autoSlide"];
    if(empty($auto_slide)) $auto_slide = false;
    
    $slide_interval = $attributes["slideInterval"];
    if(empty($slide_interval)) $slide_interval = 5;

    // Convert from seconds to miliseconds
    $slide_interval *= 1000;


    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-carousel carousel slide <?php echo "eb-show-controls-$show_controls eb-show-indicators-$show_indicators" ?>" 
        data-bs-ride="<?php echo ($auto_slide) ? "carousel" : "false" ?>" 
        data-bs-interval="<?php echo ($auto_slide) ? $slide_interval : "" ?>" 
        id="<?php echo $block_id; ?>">

            <div class="carousel-inner">
                <?php echo $content ?>
            </div>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
