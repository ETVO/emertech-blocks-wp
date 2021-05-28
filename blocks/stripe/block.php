<?php

function render_block_stripe($attributes) {
    $title = $attributes['title'];
    $text = $attributes['text'];
    $brand_url = $attributes['brand'];
    $btn_text = $attributes['btnText'];
    $btn_url = $attributes['btnUrl'];
    $btn_new_tab = $attributes['btnNewTab'];

    $btn_target = ($btn_new_tab) ? "_blank": "_self";

    $common_aos = ' data-aos-offset="100"';

    $brand_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    $btn_aos = 'data-aos="fade-right" data-aos-delay="300"' . $common_aos;
    
    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-stripe text-light">
            <div class="d-flex ps-0 pb-0 pt-5">
                <div class="brand m-0 mt-auto" <?php echo $brand_aos; ?>>
                    <img src="<?php echo $brand_url; ?>" alt="" class="brand-img">
                </div>
                <div class="container p-5">
                    <div class="content col-12 col-lg-10 pb-5 ps-3">
                        <div class="title text-uppercase" <?php echo $title_aos; ?>>
                            <h2>
                                <?php echo $title; ?> 
                            </h2>
                        </div>

                        <div class="text fw-lighter" <?php echo $text_aos; ?>>
                            <p>
                                <?php echo $text; ?>  
                            </p>
                        </div>

                        <div class="action text-uppercase" <?php echo $btn_aos; ?>>
                            <a 
                            class="eb-link light" 
                            href="<?php echo $btn_url; ?>" 
                            target="<?php echo $btn_target; ?>">
                                <?php echo $btn_text; ?>  
                            </a>
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