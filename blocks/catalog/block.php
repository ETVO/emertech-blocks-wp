<?php

function render_block_catalog($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $post_type = $attributes['postType'];
    $use_transform = $post_type == 'transform';
    
    $no_of_posts = $attributes['noOfPosts'];
    
    $primary_btn_label = $attributes['primaryBtnLabel'];
    $primary_btn_icon = $attributes['primaryBtnIcon'];
    $primary_btn_link = get_post_type_archive_link( $post_type );
    
    $secondary_btn_label = $attributes['secondaryBtnLabel'];
    $secondary_btn_icon = $attributes['secondaryBtnIcon'];
    $secondary_btn_link = $attributes['secondaryBtnLink'];
    $secondary_btn_download = $attributes['secondaryBtnDownload'];

    $view_more_label = get_theme_mod( 'emertech_transform_strings_view_more' );
    if($view_more_label == '') $view_more_label = __('Ver Mais');
    
    
    ob_start(); // Start HTML buffering
    $transform_exists = class_exists('Emertech_Transform_CPT');

    if ($use_transform && !$transform_exists) {
        echo "<script>";
        echo "console.error(\"Plugin Emertech Transformations is missing so catalog block cannot be rendered.\");";
        echo "</script>";
        return;
    }

    // WP_Query arguments
    $args = array(
        'post_type'              => $post_type,
        'post_status'            => array('publish'),
        'has_password'           => false,
        'posts_per_page'         => $no_of_posts,
        'no_found_posts'         => true,
        'order'                  => 'ASC',
        'orderby'                => 'menu_order',
    );

    // The Query
    $query = new WP_Query($args);
    
    if ($query->have_posts()) :
        ?>
        <section class="eb-catalog" id="<?php echo $anchor; ?>">
            <div class="container my-5">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
                    <?php
                    while ($query->have_posts()) :
                        $query->the_post();
                        
                        $post = get_post();
                        
                        $permalink = esc_url(get_the_permalink());
                        
                        $image_url = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
                        $image_alt = get_the_post_thumbnail_caption();
                        
                        $category = get_the_category();
                        if ($use_transform)
                        $category = get_the_terms($post->ID, 'tipo');
                        
                        $title = get_the_title();
                        $excerpt = get_the_excerpt();
                        ?>
                        <div class="col p-2">
                            
                            <div class="card bg-dark position-relative clink" href="<?php echo $permalink; ?>">

                                <?php if ($image_url != ''){ ?>
                                    <div class="image">
                                        <img src="<?php echo $image_url; ?>" class="card-img-top" 
                                        alt="<?php echo $image_alt; ?>">
                                    </div>
                                <?php } else { ?>
                                    <div class="image-placeholder"></div>
                                <?php } ?>

                                    <div class="card-body">
                                        <a href="<?php echo $permalink; ?>" class="title eb-link after" 
                                        aria-label="<?php echo $view_more_label . " - $title";  ?>"
                                        title="<?php echo $view_more_label . " - $title";  ?>">
                                            <h5 class="d-inline-block card-title">
                                                <?php echo $title; ?>
                                            </h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                    endwhile;
                    ?>
                </div>
                <?php if($primary_btn_label != ''): ?>
                    <div class="d-flex mt-5">
                        <a class="btn btn-primary text-uppercase m-auto" href="<?php echo $primary_btn_link; ?>">
                            <span class="bi bi-<?php echo $primary_btn_icon; ?>"></span>
                            <?php echo $primary_btn_label; ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if($secondary_btn_label != ''): ?>
                    <div class="d-flex mt-3">
                        <a class="btn btn-secondary text-uppercase m-auto" style="font-size: 0.9em;" 
                        href="<?php echo $secondary_btn_link; ?>"
                        <?php if($secondary_btn_download) echo "target=\"_blank\" download"; ?>>
                            <span class="bi bi-<?php echo $secondary_btn_icon; ?>"></span>
                            <?php echo $secondary_btn_label; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    endif;
    
    $output = ob_get_contents(); // collect buffered contents
    
    ob_end_clean(); // Stop HTML buffering
    
    return $output; // Render contents

    // Restore original Post Data
    wp_reset_postdata();
}
