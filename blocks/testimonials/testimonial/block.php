<?php

function render_block_testimonial($attributes, $content)
{

    $rating = $attributes['rating'];
    $message = $attributes['message'];
    $author = $attributes['author'];
    $picture_url = $attributes['picture'];
    $show_picture = $attributes['showPicture'];
    if(empty($show_picture)) $show_picture = 0;

    $common_aos = ' data-aos-offset="200"';

    $image_aos = 'data-aos="fade-up" data-aos-delay="100"' . $common_aos;
    $author_aos = 'data-aos="fade" data-aos-delay="200"' . $common_aos;
    $message_aos = 'data-aos="fade" data-aos-delay="300"' . $common_aos;
    $star_aos = ' data-aos="fade"' . $common_aos;

    $filled_icon = "star-fill";

    $star_speed = 100;

    ob_start(); // Start HTML buffering

    ?>

        <div class="eb-testimonial carousel-item">
            <div class="content d-block text-center">
                <?php if($show_picture): ?>
                    <img src="<?php echo $picture_url; ?>" class="author-image" alt="" <?php echo $image_aos; ?>>
                <?php endif; ?>

                <h5 class="author mt-2" <?php echo $author_aos; ?>>
                    <?php echo $author; ?>
                </h5>

                <p class="message" <?php echo $message_aos; ?>>
                    <?php echo $message; ?>
                </p>

                <h5 class="rating">
                    <?php 
                        for($i = 0; $i < $rating; $i++): 
                            $star_delay = ($i + 1) * $star_speed;
                            $star_aos = "data-aos-delay=\"$star_delay\" $star_aos";
                    ?>
                            <span class="bi bi-<?php echo $filled_icon; ?> text-primary" <?php echo $star_aos; ?>></span>
                    <?php endfor; ?>
                    
                    <?php 
                        for($i = 5; $i > $rating; $i--): 
                            $star_delay = ($i + 1) * $star_speed;
                            $star_aos = "data-aos-delay=\"$star_delay\" $star_aos";
                    ?>
                            <span class="bi bi-<?php echo $filled_icon; ?> text-secondary" <?php echo $star_aos; ?>></span>
                    <?php endfor; ?>
                </h5>
            </div>
        </div>

    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
