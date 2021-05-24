<?php

function render_block_present($attributes)
{

    $title1 = $attributes['title1'];
    $title2 = $attributes['title2'];
    $text = $attributes['text'];
    $image_top_url = $attributes['imageTop'];
    $image_side_url = $attributes['imageSide'];
    $brand_url = $attributes['brand'];
    $link_text = $attributes['linkText'];
    $link_anchor = $attributes['linkAnchor'];

    $common_aos = ' data-aos-offset="100"';

    $brand_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    $btn_aos = 'data-aos="fade-right" data-aos-delay="300"';
    $img_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-present">
            <div class="image-top" style="background-image: url('<?php echo $image_top_url; ?>');">
                <div class="d-flex h-100 d-none">
                    <div class="brand mt-auto"
                    <?php echo $brand_aos; ?>>
                        <img src="<?php echo $brand_url; ?>" alt="" class="brand-img">
                    </div>
                </div>
            </div>
            <div class="wrap bg-dark text-light px-4">
                <div class="col-9 row m-auto p-3">
                    <div class="content col-12 col-lg-8">
                        <div class="title text-uppercase"
                        <?php echo $title_aos; ?>>
                            <h1>
                                <?php echo $title1; ?> 
                                <span><?php echo $title2; ?></span>
                            </h1>
                        </div>

                        <div class="p-2">

                        </div>

                        <div class="text fw-lighter"
                        <?php echo $text_aos; ?>>
                            <p>
                                <?php echo $text; ?>  
                            </p>
                        </div>

                        <div class="action text-uppercase"
                        <?php echo $btn_aos; ?>>
                            <a 
                            class="eb_link light down ico-lg" 
                            href="<?php echo $link_anchor; ?>">
                                <?php echo $link_text; ?>  
                            </a>
                        </div>
                    </div>
                    <div class="image col-lg-4"
                        <?php echo $img_aos; ?>>
                        <div class="image-side">
                            <img src="<?php echo $image_side_url; ?>" alt="" class="img-fluid">
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
