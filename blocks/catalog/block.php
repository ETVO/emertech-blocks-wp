<?php

function render_block_catalog($attributes, $content)
{
    $anchor = $attributes['anchor'];
    $post_type = $attributes['postType'];
    $use_transform = $post_type == 'transform';

    $archive_label = $attributes['viewAllLabel'];
    
    $view_more_label = __('Ver mais sobre ');
    $archive_link = get_post_type_archive_link( $post_type );
    
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
        'posts_per_page'         => '8',
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
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-xxl-4">
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
                                        aria-label="<?php echo $view_more_label . $title;  ?>">
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
                <div class="d-flex mt-2">
                    <a class="btn btn-primary text-uppercase m-auto eb-link plus light-ico" href="<?php echo $archive_link; ?>">
                        <?php echo $archive_label; ?>
                    </a>
                </div>
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
