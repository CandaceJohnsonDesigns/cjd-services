<?php

function cjd_blocks_render_block_services_overview( $block_attributes, $content ) {
    return sprintf('<p>%1$s</p>', "I'm rendered!");
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */
function cjd_services_register_services_overview() {
    register_block_type( 
        plugin_dir_path( __FILE__ ) . 'blocks/services-overview/'
    );
}
add_action( 'init', 'cjd_services_register_services_overview' );