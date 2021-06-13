<?php

function render_block_content($attributes, $content) {
    $anchor = $attributes['anchor'];

    $common_aos = ' data-aos-offset="100"';

    $content_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    
    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-content" id="<?php echo $anchor; ?>" <?php echo $content_aos; ?>>
            <div class="content col-12 col-sm-10 col-md-9 col-lg-8 py-4 m-auto">
                <?php echo $content; ?>
            </div>
        </section>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}