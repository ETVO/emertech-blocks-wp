<?php

function render_block_present($attributes)
{

    $title1 = $attributes['title1'];
    $title2 = $attributes['title2'];
    $text = $attributes['text'];
    
    $text_order = $attributes['textOrder'] ?? "first";
    $align = $attributes['align'] ?? "start";
    $padding = $attributes['padding'] ?? 2;

    $image_top_url = $attributes['imageTop'];
    $show_image_top = $attributes['showImageTop'];
    if(empty($show_image_top)) $show_image_top = '0';

    $image_side_url = $attributes['imageSide'];
    $show_image_side = $attributes['showImageSide'] ?? '0';
    if(empty($show_image_side)) $show_image_side = '0';

    $brand_url = $attributes['brand'];
        
    $link_text = $attributes['linkText'];
    $link_anchor = $attributes['linkAnchor'];    
    $link_arrow = $attributes['linkArrow'] ?? "down";    

    if($padding <= 2) $colSize = 9;
    if($padding <= 4) $colSize = 10;
    if($padding == 5) $colSize = 11;
    if(!$show_image_side) $colSize = 9;

    $common_aos = ' data-aos-offset="100"';

    $brand_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;
    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;
    $text_aos = 'data-aos="fade-right" data-aos-delay="200"' . $common_aos;
    $btn_aos = 'data-aos="fade-right" data-aos-delay="300"';
    $img_aos = 'data-aos="fade" data-aos-delay="100"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-present <?php echo "show-image-top-$show_image_top show-image-side-$show_image_side"; ?>">
            <div class="image-top" style="background-image: url('<?php echo $image_top_url; ?>');">
                <div class="d-flex h-100 d-none">
                    <!-- hiding it for now... -->
                    <div class="brand mt-auto"
                    <?php echo $brand_aos; ?>>
                        <img src="<?php echo $brand_url; ?>" alt="" class="brand-img">
                    </div>
                </div>
            </div>
            <div class="bottom-part bg-dark text-light <?php echo "text-$align"; ?>">
                <div class="bottom-wrap row col-12 col-sm-11 col-md-10 col-lg-<?php echo $colSize ?> m-auto py-5">
                    <div class="content col-12 col-lg-8 px-2 <?php echo "order-$text_order"; if(!$show_image_side) echo " col-lg-10"; else echo " px-lg-$padding"; ?>">
                        <div class="title text-uppercase"
                        <?php echo $title_aos; ?>>
                            <h1>
                                <?php echo $title1; ?> 
                                <span class="<?php if($title2 == NULL) echo "d-none"; ?>">
                                    <?php echo $title2; ?>
                                </span>
                            </h1>
                        </div>

                        <div class="p-2">

                        </div>

                        <div class="text fw-light"
                        <?php echo $text_aos; ?>>
                            <p>
                                <?php echo $text; ?>  
                            </p>
                        </div>

                        <div class="action text-uppercase <?php if($link_text == NULL) echo "d-none"; ?>"
                        <?php echo $btn_aos; ?>>
                            <a 
                            class="eb-link light <?php echo $link_arrow; ?> ico-lg" 
                            href="<?php echo $link_anchor; ?>">
                                <?php echo $link_text; ?>  
                            </a>
                        </div>
                    </div>
                    <div class="image-side m-auto mt-3 col-12 col-md-8 col-lg-4 <?php echo " px-$padding"; ?>"
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
