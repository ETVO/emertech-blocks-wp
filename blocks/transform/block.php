<?php

function render_block_transform($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $form_title = get_theme_mod("emertech_transform_form_title"); 

    ob_start(); // Start HTML buffering
    $is_transform = class_exists('Emertech_Transform_CPT') && is_singular('transform');

    $optionals_title = get_theme_mod('emertech_transform_optionals_title');
    
    $hide_form = get_theme_mod('emertech_transform_form_hide', 0);

    $continue_btn_label = get_theme_mod( 'emertech_transform_strings_continue_btn' );
    if($continue_btn_label == '') $continue_btn_label = __('Continuar');
?>

    <section class="eb-transform my-3 my-md-4 my-lg-5" id="<?php echo $anchor; ?>">
        <form action="" method="post">
            <div class="container py-0">
                <div class="row">
                    <div class="col-12 col-lg-8 <?php if(!$is_transform || $hide_form) echo "m-auto"; ?>">
                        <div class="content">
                            <?php 
                                echo $content;
                            ?>
                        </div>
                        <?php if($is_transform): ?>
                            <div class="meta">
                                <?php if( get_the_terms( get_the_ID(), 'opcional' ) ): ?>
                                    <div class="caracters pt-4">
                                        <?php
                                            get_transform_template_part('partials/component-caracters'); 
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <?php if( get_the_terms( get_the_ID(), 'opcional' ) ): ?>
                                    <div class="optionals-wrap my-3">
                                        <div class="optionals border border-primary rounded <?php if($optionals_title != '') echo 'show-title'; ?>">
                                            <?php if($optionals_title != ''): ?>
                                                <div class="title">
                                                    <h6 class="text-uppercase fw-normal bg-dark rounded px-1 text-primary">
                                                        <?php echo $optionals_title; ?>
                                                    </h6>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                                get_transform_template_part('partials/component-optionals'); 
                                            ?>

                                            <button id="continueToRequestBtn" class="btn btn-primary d-none continue" type="button">
                                                <?php echo $continue_btn_label; ?>
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($is_transform && !$hide_form): ?>
                        <div class="form-parent col-12 col-md-6 m-auto m-lg-0 col-lg-4 ps-md-0 pt-4 pt-lg-0 ps-lg-4 ps-xl-5 d-flex d-lg-block">
                            <div class="form p-3 rounded w-100"
                                title="<?php echo __('Últimos passos para enviar a sua solicitação!'); ?>" 
                                data-bs-placement="left"
                                data-bs-custom-class="primary-tooltip">

                                <?php if($form_title != ''): ?>
                                    <div class="title">
                                        <h5><?php echo $form_title; ?></h5>
                                    </div>
                                <?php endif; ?>
                                
                                <?php 
                                    get_transform_template_part('partials/component-form');
                                ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
