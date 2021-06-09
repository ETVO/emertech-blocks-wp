<?php

function render_block_timeline($attributes, $content) 
{
    $anchor = $attributes['anchor'];
    $title = $attributes['title'];
    $show_title = $attributes['showTitle'];
    
    $common_aos = ' data-aos-offset="100"';

    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-timeline py-3 <?php echo "show-title-$show_title"; ?>" id="#<?php echo $anchor; ?>">
            <div class="container col-11 col-md-10 col-lg-9 col-xl-8">
                <div class="title text-uppercase" <?php echo $title_aos; ?>>
                    <h2>
                        <?php echo $title; ?>
                    </h2>
                </div>
                <div class="wrap mt-4">
                    <?php echo $content; ?>
                </div>
            </div>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}