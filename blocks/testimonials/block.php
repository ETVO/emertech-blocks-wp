<?php

function render_block_testimonials($attributes, $content) 
{
    $anchor = $attributes['anchor'];

    $title = $attributes['title'];
    $show_title = $attributes['showTitle'];
    if(empty($show_title)) $show_title = 0;

    $block_id = $attributes['block_id'];
    if(empty($block_id)) $block_id = "eb-testimonials-" . rand(0, 999);
    
    $auto_slide = $attributes["autoSlide"];
    if(empty($auto_slide)) $auto_slide = 0;
    
    $common_aos = ' data-aos-offset="100"';
    $title_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    $carousel_aos = 'data-aos="fade" data-aos-delay="200"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-testimonials py-5 <?php echo "show-title-$show_title"; ?>" id="<?php echo $anchor; ?>">
            <div class="container col-12 col-sm-11 col-md-10 col-lg-9 px-2 px-md-0">
                <div class="title text-uppercase text-center" <?php echo $title_aos; ?>>
                    <h2>
                        <span class="bi bi-chat-square-quote-fill text-primary d-block"></span>
                        <?php echo $title; ?>
                    </h2>
                </div>
                <section class="carousel slide" <?php $carousel_aos; ?>
                data-bs-ride="<?php echo ($auto_slide) ? "carousel" : "false" ?>" 
                data-bs-interval="<?php echo ($auto_slide) ? "10000" : "" ?>" 
                id="<?php echo $block_id; ?>">

                    <div class="carousel-inner">
                        <?php echo $content ?>
                    </div>
                    
                    <button class="carousel-control-prev" type="button"
                    data-bs-target="#<?php echo $block_id; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?php echo __("Anterior"); ?></span>
                    </button>
                    <button class="carousel-control-next" type="button"
                    data-bs-target="#<?php echo $block_id; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?php echo __("Próximo"); ?></span>
                    </button>
                </section>
            </div>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}