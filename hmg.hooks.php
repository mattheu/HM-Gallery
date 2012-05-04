<?php


/**
 *	Remove the Featured image meta box if gallery is set to manage featured. 
 */
function hmg_remove_featured() {

	if( get_option( 'hmg_manage_featured', true ) && get_option( 'hmg_post_type' ) )
		foreach( get_option( 'hmg_post_type' ) as $post_type )
			remove_meta_box( 'postimagediv', $post_type, 'side' );

}
add_action( 'do_meta_boxes', 'hmg_remove_featured' );

/**
 *	Styling for the admin
 */
function hmg_admin_styles() {

	?>
	<style type="text/css">
		#hmg_gallery_images_container { clear: both; }
   		#additional-images .inside { padding-top: 35px !important; }
   		#additional-images p.hmg_gallery_images_submit { margin-top: -28px !important; float: left !important; }
	</style>
	<?php

	if( get_option( 'hmg_manage_featured', true ) ) :

	?>
	<style type="text/css">
   		#additional-images .sortable .image-wrapper.first { background-color: #FFFFE0; border-color: #E6DB55; }
	/*	#additional-images .sortable .image-wrapper.first:after { content: 'Featured Image'; font-weight: bold; display: block; position: absolute; width: 162px; text-align: center; top: -25px; left: 0; }*/
    </style>
	<?php
	endif;
	
}
add_action( 'admin_head', 'hmg_admin_styles' );