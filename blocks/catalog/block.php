<?php

function render_block_catalog($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $post_type = $attributes['postType'];

    ob_start(); // Start HTML buffering
    $is_transform = class_exists('Emertech_Transform_CPT') && is_singular('transform');
?>

    <section class="eb-catalog my-3" id="<?php echo $anchor; ?>">
        <div class="container py-0">
            
        </div>
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
