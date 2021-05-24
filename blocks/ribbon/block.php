<?php

function render_block_ribbon($attributes) {
    $title = $attributes['title'];
    $text = $attributes['text'];
    $anchor = $attributes['anchor'];
    $align = $attributes['align'] ?? "right";
    $bgColor = $attributes['bgColor'] ?? "red";

    $common_aos = ' data-aos-offset="100"';

    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    
    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-ribbon <?php echo "eb-bg-$bgColor eb-align-$align"; ?>" id="<?php echo $anchor; ?>">
            <div class="top-part"></div>
            <div class="main-part d-flex p-2">
                <div class="container p-3 pb-4">
                    <div class="content col-12 col-lg-10 m-auto px-2 text-light">
                        <div class="title py-2 mt-auto text-uppercase" <?php echo $title_aos; ?>>
                            <h2>
                                <?php echo $title; ?> 
                            </h2>
                        </div>

                        <div class="text fw-light" <?php echo $text_aos; ?>>
                            <p>
                                <?php echo $text; ?>  
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-part"></div>
            <div class="backdrop"></div>
        </section>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}