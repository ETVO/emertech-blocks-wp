<?php

function render_block_compact($attributes) {
    $title = $attributes['title'];
    $subtitle = $attributes['subtitle'];
    $symbol_url = $attributes['symbol'];
    $shortcode = $attributes['shortcode'];

    $common_aos = ' data-aos-offset="100"';

    $symbol_aos = 'data-aos="fade-down" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-down" data-aos-delay="100"' . $common_aos;
    $subtitle_aos = 'data-aos="fade-down" data-aos-delay="200"' . $common_aos;
    $form_aos = 'data-aos="fade" data-aos-delay="300" data-aos-duration="600"' . $common_aos;


    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-compact text-light bg-dark py-5">
            <div class="row m-0 py-5">
                <div class="wrap col-10 col-md-8 col-lg-5 m-auto text-center">
                    <div class="symbol d-flex mb-2" <?php echo $symbol_aos; ?>>
                        <img src="<?php echo $symbol_url; ?>" alt="" class="symbol_img m-auto">
                    </div>
                    <div class="title text-uppercase" <?php echo $title_aos; ?>>
                        <h2 class="mb-0">
                            <?php echo $title; ?>
                        </h2>
                    </div>
                    <div class="subtitle text-uppercase fs-4" <?php echo $subtitle_aos; ?>>
                        <h2 class="fw-light mt-0">
                            <?php echo $subtitle; ?>
                        </h2>
                    </div>
                    <div class="shortcode text-break" <?php echo $form_aos; ?>>
                        <?php echo $shortcode; ?>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control d-block w-100 my-3 mx-4 bg-dark text-light" placeholder="E-mail">
                            </div>
                            <input type="submit" class="btn btn-primary px-4" value="INSCREVER" onclick="return false;">
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}