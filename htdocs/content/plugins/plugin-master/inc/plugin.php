<?php

// Customize WordPress...
function my_project_updated_send_email( $post_id ) {
 
    // If this is just a revision, don't send the email.
    if ( wp_is_post_revision( $post_id ) ) {
        return;
        }
 
 $post_title = get_post( $post_id );
 
 //print_r( $post_title->post_date_gmt);
  
//die;
}
add_action( 'save_post', 'my_project_updated_send_email' );

add_action("admin_menu", "addMenu");

function addMenu() {
    add_menu_page("Products With meta", "Products With meta", "edit_posts",
        "mynewmenu", "displayPage", null, 1);
}




function displayPage() {
       $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
        echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail().' '.get_the_title().'</a>';
    endwhile;

    wp_reset_query();
}