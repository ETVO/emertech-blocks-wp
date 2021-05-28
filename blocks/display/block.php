<?php

function render_block_display($attributes) {
    $image_url = $attributes['image'];
    $title = $attributes['title'];
    $text = $attributes['text'];
    $btn_text = $attributes['btnText'];
    $btn_url = $attributes['btnUrl'];
    $btn_new_tab = $attributes['btnNewTab'];
    $align_style = $attributes['alignStyle'];
    
    $content_class = " order-md-last";
    $text_align_class = " text-end";
    $image_class = "ms-auto";
    
    if($align_style == "left") {
        $content_class = " order-md-first";
        $text_align_class = " text-start";
        $image_class = "me-auto";

        $align_style = "-left";
        $opposite_align_style = "-right";
    }
    else { 
        $align_style="-right"; 
        $opposite_align_style = "-left"; 
    }
    
    $align_style = "";
    // $opposite_align_style = "";
    
    $image_aos = 'data-aos="fade' . $align_style . '" data-aos-delay="0" data-aos-offset="100"';
    $title_aos = 'data-aos="fade' . $opposite_align_style . '" data-aos-delay="0" data-aos-offset="100"';
    $text_aos = 'data-aos="fade' . $opposite_align_style . '" data-aos-delay="100" data-aos-offset="100"';
    $btn_aos = 'data-aos="fade' . $opposite_align_style . '" data-aos-delay="200" data-aos-offset="0"';

    $btn_target = ($btn_new_tab) ? "_blank": "_self";

    ob_start(); // Start HTML buffering

    ?>

        <section class="eb-display bg-dark text-light py-4 p-lg-5">
            <div class="container px-md-2 px-lg-5">
                <div class="row m-auto">
                    <div class="col-md-6 col-lg-6 <?php echo $image_class; ?>">
                        <div class="image" <?php echo $image_aos; ?>>
                            <a href="<?php echo $btn_url; ?>" target="<?php echo $btn_target; ?>">
                                <img src="<?php echo $image_url; ?>" alt="" class="img-fluid rounded">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 py-4 <?php echo $content_class . $text_align_class; ?>">
                        <div class="content">
                            <div class="title text-uppercase" <?php echo $title_aos; ?>>
                                <h2>
                                    <?php echo $title; ?> 
                                </h2>
                            </div>

                            <div class="text fw-light" <?php echo $text_aos; ?>>
                                <p>
                                    <?php echo $text; ?>  
                                </p>
                            </div>

                            <div class="action text-uppercase " <?php echo $btn_aos; ?>>
                                <a 
                                class="eb-link primary" 
                                href="<?php echo $btn_url; ?>" 
                                target="<?php echo $btn_target; ?>">
                                    <?php echo $btn_text; ?>  
                                </a>
                            </div>
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
