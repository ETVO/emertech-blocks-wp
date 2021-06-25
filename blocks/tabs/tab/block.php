<?php

function render_block_tab($attributes, $content)
{

    ob_start(); // Start HTML buffering

    ?>
        <div class="tabs-section tab-pane fade p-3 mt-3" role="tabpanel">
            <?php echo $content; ?>
        </div>
    <?php

    $output = ob_get_contents(); // collect buffered contents

    ob_end_clean(); // Stop HTML buffering

    return $output; // Render contents
}
