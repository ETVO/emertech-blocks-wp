<?php

function render_block_transform($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $form_title = get_theme_mod("emertech_transform_form_title"); 

    ob_start(); // Start HTML buffering
    $is_transform = class_exists('Emertech_Transform_CPT') && is_singular('transform');

    $optionals_title = __('Monte o seu orçamento');
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
                        <div class="meta py-3">
                            <div class="caracters pb-3">
                                <?php
                                    if($is_transform)
                                        get_transform_template_part('partials/component-caracters'); 
                                ?>
                            </div>

                            <div class="optionals border border-primary rounded">
                                <div class="title">
                                    <h6 class="text-uppercase fw-normal bg-dark rounded px-1 text-primary">
                                        <?php echo $optionals_title; ?>
                                    </h6>
                                </div>

                                <?php
                                if($is_transform)
                                    get_transform_template_part('partials/component-optionals'); 
                                ?>

                                <button id="continueToRequestBtn" class="btn btn-primary d-none continue" type="button">
                                    <?php echo __('Continuar'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-parent col-12 col-lg-4 ps-lg-4 ps-xl-5 d-flex flex-column d-lg-block">
                        <div class="form p-3 rounded m-auto"
                            title="<?php echo __('Últimos passos para enviar a sua solicitação!'); ?>" 
                            data-bs-placement="left"
                            data-bs-custom-class="primary-tooltip">

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
