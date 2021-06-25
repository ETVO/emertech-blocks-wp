<?php

function render_block_transform($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $form_title = get_theme_mod("emertech_transform_form_title"); 

    ob_start(); // Start HTML buffering
    $is_transform = class_exists('Emertech_Transform_CPT') && is_singular('transform');
?>

    <section class="eb-transform my-3 my-md-4 my-lg-5" id="<?php echo $anchor; ?>">
        <form action="">
            <div class="container py-0">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="content">
                            <?php 
                                echo $content;
                            ?>
                        </div>
                        <div class="optionals">
                            <?php
                                if($is_transform)
                                    get_transform_template_part('partials/component-optionals'); 
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 pt-2 pt-lg-0 ps-lg-4 ps-xl-5 d-flex d-lg-block">
                        <div class="form p-3 rounded m-auto">

                            <?php if($form_title != ''): ?>
                                <div class="title">
                                    <h4><?php echo $form_title; ?></h4>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                                if($is_transform)
                                    get_transform_template_part('partials/component-form');
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
