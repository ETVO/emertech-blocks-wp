<?php

function render_block_compact($attributes, $content) {
    $title = $attributes['title'];
    
    $subtitle = $attributes['subtitle'];

    $symbol_url = $attributes['symbol'];

    $common_aos = ' data-aos-offset="100"';

    $symbol_aos = 'data-aos="fade-down" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-down" data-aos-delay="100"' . $common_aos;
    $subtitle_aos = 'data-aos="fade-down" data-aos-delay="200"' . $common_aos;
    $content_aos = 'data-aos="fade-up" data-aos-delay="400"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-compact text-light bg-dark">
            <div class="col-12 col-sm-11 col-md-10 col-lg-9 d-flex py-3 py-md-4 py-lg-5 px-3 m-auto">
                <div class="wrap container col-12 col-lg-10 m-auto text-center px-2">
                    <div class="symbol d-flex mb-2" <?php echo $symbol_aos; ?>>
                        <img src="<?php echo $symbol_url; ?>" alt="" class="img-fluid symbol-img m-auto">
                    </div>
                    <div class="title" <?php echo $title_aos; ?>>
                        <h2 class="mb-0">
                            <span class="d-block"<?php echo $title_aos; ?>>
                                <?php echo $title; ?>
                            </span>
                        </h2>
                        <h4 class="mb-0">
                            <span class="d-block fw-lighter" <?php echo $subtitle_aos; ?>>
                                <?php echo $subtitle; ?>
                            </span>
                        </h4>
                    </div>
                    <div class="content text-break pt-2" <?php echo $content_aos; ?>>
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}