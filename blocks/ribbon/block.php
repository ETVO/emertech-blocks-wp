<?php

function render_block_ribbon($attributes)
{
    $title = $attributes['title'];
    $text = $attributes['text'];
    $anchor = $attributes['anchor'];
    $align = $attributes['align'] ?? "right";
    $bgColor = $attributes['bgColor'] ?? "red";
    $style = $attributes['style'] ?? "rounded";

    if ($anchor == "") {
        $anchor = strtolower($title) . rand(100, 999);
    }

    $common_aos = ' data-aos-offset="100"';

    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    $bg_aos = 'data-aos="fade-right" data-aos-delay="0"';
    $bg_aos = '';

    $start_expanded = false;

    ob_start(); // Start HTML buffering

?>

    <section class="eb-ribbon <?php echo "eb-bg-$bgColor eb-align-$align eb-style-$style"; ?>">
    
        <div class="top-part">
            <?php if($style == "rounded"): ?>
            <img src="<?php echo EMERTECH_PLUGIN_IMG_URL . 'top.svg'; ?>" alt="" <?php echo $bg_aos; ?>>
            <?php endif; ?>
        </div>

        <div class="main-part d-flex p-2" id="<?php echo $anchor; ?>">
            <div class="container p-3 pt-0 text-light">
                <h2 class="accordion-header" id="header<?php echo $anchor; ?>">
                    <button class="accordion-button <?php echo ($start_expanded) ? "" : "collapsed"; ?>" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $anchor; ?>" 
                        aria-expanded="<?php echo $start_expanded; ?>" aria-controls="collapse<?php echo $anchor; ?>" 
                        <?php echo $title_aos; ?>
                        >
                        <h2 class=" title text-uppercase">
                            <?php echo $title; ?>
                        </h2>
                    </button>
                </h2>
                <div id="collapse<?php echo $anchor; ?>" 
                    class="accordion-collapse collapse  <?php echo ($start_expanded) ? "show" : ""; ?>" 
                    aria-labelledby="header<?php echo $anchor; ?>" 
                    data-bs-parent="#<?php echo $anchor; ?>"
                    >
                    <div class="accordion-body content text fw-light">
                        <p <?php echo $text_aos; ?>>
                            <?php echo $text; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-part" <?php echo $bg_aos; ?>>
            <?php if($style == "rounded"): ?>
                <img src="<?php echo EMERTECH_PLUGIN_IMG_URL . 'bottom.svg'; ?>" alt="">
            <?php endif; ?>
        </div>
        
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
