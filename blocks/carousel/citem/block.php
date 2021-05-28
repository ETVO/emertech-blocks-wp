<?php

function render_block_citem($attributes)
{

    $image_url = $attributes['image'];
    $title = $attributes['title'];
    $text = $attributes['text'];
    $show_caption = $attributes['showCaption'];
    if(empty($show_caption)) $show_caption = false;

    $common_aos = ' data-aos-offset="100"';

    $image_aos = 'data-aos="fade-left" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-left" data-aos-delay="200"' . $common_aos;
    $text_aos = 'data-aos="fade" data-aos-delay="300"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>
        <?php if($image_url): ?>
        <div class="eb-citem carousel-item">
            <img src="<?php echo $image_url; ?>" class="d-block w-100" <?php echo $image_aos; ?>>
            <?php if($show_caption): ?>
            <div class="carousel-caption d-none d-md-block">
                <h5><?php echo $title; ?></h5>
                <p>
                    <?php echo $text; ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
