<?php

function render_block_hero($attributes)
{

    $bg_image_url = $attributes['bgImage'];
    $title = $attributes['title'];
    $text = $attributes['text'];
    $btn_text = $attributes['btnText'];
    $btn_url = $attributes['btnUrl'];
    $btn_new_tab = $attributes['btnNewTab'];
    
    $btn_target = ($btn_new_tab) ? "_blank": "_self";
    
    $common_aos = 'data-aos="fade-right"';
    $title_aos = $common_aos . ' data-aos-delay="100"';
    $text_aos = $common_aos . ' data-aos-delay="100"';
    $btn_aos = $common_aos . ' data-aos-delay="100"';

    ob_start(); // Start HTML buffering


    ?>

        <section class="eb-hero d-flex flex-row p-4 px-md-0 pt-md-0" style="background-image: url('<?php echo $bg_image_url; ?>');">
            <div class="container mt-auto text-light pb-2">
                <div class="content mr-auto col-12 col-md-9 col-lg-6">
                    <div class="title text-uppercase" 
                    <?php echo $title_aos; ?> >
                        <h2>
                            <?php echo $title; ?> 
                        </h2>
                    </div>

                    <div class="text" 
                    <?php echo $text_aos; ?>>
                        <p>
                            <?php echo $text; ?>  
                        </p>
                    </div>

                    <div class="action text-uppercase" 
                    <?php echo $btn_aos; ?> >
                        <a 
                        class="eb-link light" 
                        href="<?php echo $btn_url; ?>" 
                        target="<?php echo $btn_target; ?>">
                            <?php echo $btn_text; ?>  
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
