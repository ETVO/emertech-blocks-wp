<?php

function render_block_carousel($attributes, $content)
{
    $block_id = $attributes["blockId"];
    if(empty($block_id)) $block_id = "eb-carousel-" . rand(0, 999);

    $show_indicators = $attributes["showIndicators"];
    if(empty($show_indicators)) $show_indicators = 0;

    $show_controls = $attributes["showControls"];
    if(empty($show_controls)) $show_controls = 0;

    $auto_slide = $attributes["autoSlide"];
    if(empty($auto_slide)) $auto_slide = 0;

    // echo "\n slide $auto_slide";
    // echo "\n indicators $show_indicators";
    // echo "\n controls $show_controls";
    
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
            
            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $block_id; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php echo __("Anterior"); ?></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $block_id; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden"><?php echo __("Próximo"); ?></span>
            </button>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
