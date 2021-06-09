<?php

function render_block_fragment($attributes) {
    $anchor = $attributes['anchor'];
    
    $figure_url = $attributes['figure'];
    $title = $attributes['title'];
    $text = $attributes['text'];

    $common_aos = ' data-aos-offset="100"';

    $figure_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    
    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-fragment bg-dark" id="<?php echo $anchor; ?>">
            <div class="d-flex">
                <div class="container p-4 p-lg-5">
                    <div class="content col-12 col-lg-10 m-auto px-2 text-light">
                        <div class="row">
                            <div class="col-12">
                                <div class="figure fw-lighter d-flex" <?php echo $figure_aos; ?>>
                                    <img src="<?php echo $figure_url; ?>" class="me-auto">
                                </div>
                            </div>
                            <div class="col-12 d-flex">
                                <div class="title py-2 mt-auto" <?php echo $title_aos; ?>>
                                    <h2>
                                        <?php echo $title; ?> 
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div class="text fw-light" <?php echo $text_aos; ?>>
                            <p>
                                <?php echo $text; ?>  
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}