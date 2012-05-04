<?php

// Output Functions


/**
*
*	Easy function
*
*	Output the whole gallery.
*
*	Size is either keyword or array($width, $height, $crop [true/false])
*/
function hmg_the_gallery ( $post_id = null, $size = array(), $before = null, $after = null, $link_images = true, $featured = true ) {
	
	if( null == $post_id )
		$post_id = get_the_id();

	foreach( hmg_get_gallery_images( $post_id, $size, $featured ) as $attachment_id => $image ) :
	
		if( empty( $image ) )
			continue;
	
		echo $before;
		
		if( $link_images ) : 
		
			?>
	
			<a href="<?php echo reset( wp_get_attachment_image_src( $attachment_id, 'full' ) ); ?>" rel="hm-gallery-<?php echo $post_id; ?>">
				<?php echo $image; ?>
			</a>
		
			<?php
		
		else :

			echo $image; 
		
		endif;

		echo $after;
	
	endforeach;

}



/**
 *	Get an array of the images attached to this post.
 *	
 *	Size is either keyword or array($width, $height, $crop [true/false])
 *
 *	@param int Post Id
 *	@param array size
 *	@featured bool whether to include the featured image.
 *	@return array Attachment IDs
 */
function hmg_get_gallery_images( $post_id = null, $size = array(), $featured = true ) {

	if( null == $post_id ) 
		$post_id = get_the_id();

	$images = array();

	if( $featured ) {
		$images[get_post_thumbnail_id( $post_id )] = get_the_post_thumbnail( $post_id, $size );
	}
	
	foreach( hmg_get_gallery_ids( $post_id ) as $image_id ) {
		$images[$image_id] = wp_get_attachment_image( $image_id, $size );
	}
	
	return $images;

}


/**
 *	Get the IDs of the images attached to this post.
 *	
 *	Does not return the featured image.
 *
 *	@param int Post Id
 *	@return array Attachment IDs
 */
function hmg_get_gallery_ids( $post_id = null ) {

	if( null == $post_id ) 
		$post_id = get_the_id(); 
		
	return array_filter( (array) get_post_meta( $post_id, '_hmg_gallery_images', true ) );
	
}
