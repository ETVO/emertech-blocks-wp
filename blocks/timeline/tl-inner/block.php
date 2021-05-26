<?php 

function render_block_tl_inner($attributes, $content) 
{
    $title = $attributes['title'];
    $show_title = $attributes['showTitle'];
    
    $common_aos = ' data-aos-offset="100"';

    $title_aos = 'data-aos="fade-right" data-aos-delay="100"' . $common_aos;

    ob_start(); // Start HTML buffering

    ?>
    <?php

    echo "HELLO WORLD";

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}