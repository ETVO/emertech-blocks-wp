<?php

function render_block_tabs($attributes, $content)
{

    $anchor = $attributes['anchor'];

    $block_id = 'tabsNav';
    if ($anchor) $block_id . $anchor;
    else $block_id . rand(0, 999);

    $main_title = $attributes['mainTitle'];
    $tabs_icon = $attributes['tabsIcon'];

    $noOfTabs = 3;

    ob_start(); // Start HTML buffering

?>
    <section class="eb-tabs" id="<?php echo $anchor; ?>">
        <div class="container my-5">
            <nav class="d-flex flex-column">
                <div class="title m-auto mt-2 mb-3 text-uppercase text-center">
                    <!-- <h2> 
                        <span class="bi bi-question-diamond-fill d-block mb-1 text-primary"></span>
                    </h2> -->
                    <h3>
                        <?php echo $main_title; ?>
                    </h3>
                </div>
                <div class="nav nav-pills m-auto" id="<?php echo $block_id; ?>" role="tablist">
                    <?php
                    for ($i = 1; $i != $noOfTabs + 1; $i++) :
                        if (!$attributes['hide' . $i]) :
                            $tab_icon = $attributes['tabIcon' . $i] ?? $tabs_icon;
                    ?>
                            <button class="tabs-link nav-link mx-2 text-center" data-bs-toggle="tab" type="button" role="tab">
                                <span class="bi bi-<?php echo $tab_icon; ?> d-block"></span>
                                <span class="text-light" id="<?php echo $attributes['anchor' . $i] ?>">
                                    <?php echo $attributes['title' . $i] ?>
                                </span>
                            </button>
                    <?php
                        endif;
                    endfor;
                    ?>
                </div>
            </nav>
            <div class="tab-content col-12 col-sm-10 col-md-9 col-lg-8 m-auto" id="<?php echo $block_id . 'Content'; ?>">
                <?php echo $content; ?>
            </div>
        </div>
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents

    // Restore original Post Data
    wp_reset_postdata();
}
