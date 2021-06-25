<?php

function render_block_gallery($attributes)
{

    $images = $attributes['images'];
    $title = $attributes['title'];

    $rand = rand(0, 999);
    $carousel_id = "ebGalleryCarousel" . $rand;
    $modal_id = "ebGalleryModal" . $rand;
    $modal_carousel_id = "ebGalleryModalCarousel" . $rand;

    $images_count = count($images);

    ob_start(); // Start HTML buffering

?>
    <section class="eb-gallery">
        <!-- <div class="title">
            <h4><?php echo $title; ?></h4>
        </div> -->
        <div class="row mb-4">
            
            <!-- Preview bar -->
            <div class="preview-bar px-1 py-2 px-md-2 py-md-0 col-12 col-md-2 m-auto d-flex justify-content-between flex-md-column">
                <?php 
                    for ($i = 0; $i < count($images); $i++) : 
                        
                        if($i < 4):
                                    
                            ?>
                                <div class="image-preview mx-1 mx-md-0 my-md-1">
                                    <img src="<?php echo $images[$i]['url']; ?>" class="d-block" alt="" data-bs-target="#<?php echo $carousel_id; ?>" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i; ?>">
                                </div>
                            <?php 
                            
                        endif;

                        if($i == 4):

                            $remain = $images_count - $i;
                            
                            ?>                            
                                <div class="image-preview remain"
                                data-bs-target="#<?php echo $modal_id; ?>" 
                                data-bs-toggle="modal" 
                                data-bs-dismiss="modal">
                                    <img src="<?php echo $images[$i]['url']; ?>">
                                    <div>
                                        <span>
                                            +<?php echo $remain; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php

                        endif;
                        
                    endfor; 
                ?>
            </div>

            
            <div class="slider col-12 col-md-10 p-0 order-first order-md-last">
                <div class="carousel slide" id="<?php echo $carousel_id; ?>" 
                data-bs-ride="carousel" 
                data-emertech-indicators="false">

                    <div class="carousel-inner">
                        <?php 
                            for ($i = 0; $i < $images_count; $i++): 
                            ?>
                                <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                                    <img src="<?php echo $images[$i]['url']; ?>" class="d-block w-100" alt="" 
                                    data-bs-target="#<?php echo $modal_id; ?>" 
                                    data-bs-toggle="modal" 
                                    data-bs-dismiss="modal">
                                </div>
                            <?php 
                            endfor; 
                        ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carousel_id; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?php echo __("Anterior"); ?></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carousel_id; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?php echo __("Próximo"); ?></span>
                    </button>
                </div>
            </div>


        </div>

        <div class="modal fade p-0" id="<?php echo $modal_id; ?>" aria-hidden="true" aria-label="<?php echo __('Visualização de imagens'); ?>" tabindex="-1">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content text-light">
                    <div class="modal-header">
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="<?php echo __('Fechar'); ?>">
                            <span class="bi bi-x text-light" style="line-height: 1rem; font-size: 2rem;"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="<?php echo $modal_carousel_id; ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="40000">

                            <div class="carousel-inner h-100">
                                <?php for ($i = 0; $i < count($images); $i++) : ?>
                                    <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                                        <img src="<?php echo $images[$i]['url']; ?>" class="d-block" alt="">
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $modal_carousel_id; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden"><?php echo __("Anterior"); ?></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $modal_carousel_id ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden"><?php echo __("Próximo"); ?></span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="selectors m-auto d-flex justify-content-center">
                            <?php for ($i = 0; $i < count($images); $i++) : ?>
                                <div class="image-preview">
                                    <img src="<?php echo $images[$i]['url']; ?>" class="d-block" alt="" data-bs-target="#<?php echo $modal_carousel_id; ?>" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i; ?>">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
