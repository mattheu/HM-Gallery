<?php

function hmg_gallery_meta_box( $post ) {

	$image_ids = hmg_get_gallery_ids( $post->ID );
	
	//Prepend the _thumbnail_id to the array of gallery images if the gallery is set to manage the thumbnail 
	if( get_option( 'hmg_manage_featured', true ) ) {
		$featured = array( 0 =>  get_post_meta($post->ID, '_thumbnail_id', true ) );
		$image_ids = array_merge( $featured, $image_ids );
	}

	global $temp_ID;
    $post_image_id = $post->ID ? $post->ID : $temp_ID;
	
	hm_register_custom_media_button( 'hmg_gallery_images', 'Add to Gallery', true, true, 150, 150 );
	//$non_added_text = "No Gallery Images Added " .  ( ( $hmg_url = hmg_get_url( $post ) ) ? '| <a href="' . esc_url( $hmg_url ) . '" target="_blank">Screenshot your site now</a>' : '' );

	hm_add_image_html_custom( 'hmg_gallery_images', 'Add Gallery Images', $post_image_id, $image_ids, 'sortable', 'width=150&height=150&crop=1', '' );

	wp_nonce_field( 'hmg_save_gallery_images', 'hmg_save_gallery_images_nonce' );

}

function hmg_gallery_meta_box_submitted( $post_id ) {

	if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ! wp_verify_nonce( 'hmg_save_gallery_images_nonce', 'hmg_save_gallery_images' ) )
		return;

	if ( null == $post_id )
		$post_id = get_the_id();

	$gallery_images = array();

	if ( isset( $_POST['hmg_gallery_images'] ) )
		$gallery_images = explode( ',', $_POST['hmg_gallery_images'] );

	if( ! $gallery_images && ! is_array( $gallery_images ) )
		return; 
	
	if( get_option( 'hmg_manage_featured', true ) ) {
		update_post_meta( $post_id, '_thumbnail_id', $gallery_images[0] );
		unset( $gallery_images[0] );
	}
	
	update_post_meta( $post_id, '_hmg_gallery_images', array_filter( $gallery_images ) );
}