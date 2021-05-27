<?php

function render_block_time($attributes, $content)
{

    $title = $attributes['title'];
    $show_title = $attributes['showTitle'];
    if(empty($show_title)) $show_title = '0';

    $common_aos = ' data-aos-offset="100"';

    $title_aos = 'data-aos="fade-left" data-aos-delay="200"' . $common_aos;
    $content_aos = 'data-aos="fade" data-aos-delay="300"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-time <?php echo "show-date-$show_title"; ?>">
            <div class="date" <?php echo $title_aos; ?>>
                <h2>
                    <i class="far fa-dot-circle"></i>
                    <?php echo $title; ?>
                </h2>
            </div>
            <div class="content" <?php echo $content_aos; ?>>
                <?php echo $content; ?>
            </div>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
