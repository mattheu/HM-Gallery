<?php

include_once('hmg.admin.meta-boxes.php');

function hmg_register_settings() {
	register_setting( 'hmg-settings', 'hmg_post_type' );
	register_setting( 'hmg-settings', 'hmg_append_gallery' );
	register_setting( 'hmg-settings', 'hmg_manage_featured' );
}


/**
 *	Add the meta box & the menu.
 */ 
function hmg_add_meta_boxes() {
	
	$hmg_gallery_post_types = get_option( 'hmg_post_type', array('hmg-entry') );

	add_meta_box( 'brief', 'Brief', 'hmg_brief_meta_box', 'hmg-entry', 'normal', 'high' );
	foreach( $hmg_gallery_post_types as $post_type ) {
		add_meta_box( 'additional-images', 'Gallery', 'hmg_gallery_meta_box', $post_type, 'normal', 'high' );
	}
	add_meta_box( 'additional-info', 'Additional Information', 'hmg_additional_information_meta_box', 'hmg-entry', 'side', 'low' );
	
	//register the options page
	hmg_register_settings();
	add_options_page('Gallery Settings', 'HM Gallery', 'manage_options', 'hmg-gallery-options', 'hmg_options_page');	
	
}
add_action( 'admin_menu', 'hmg_add_meta_boxes' );


/**
*	Save the gallery when we save the post.
*/
function hmg_insert_post( $post_id, $post ) {

	if ( in_array( $post->post_type, get_option( 'hmg_post_type', array('hmg-entry') ) ) )
		hmg_gallery_meta_box_submitted( $post_id );
		
}
add_action( 'wp_insert_post', 'hmg_insert_post', 10, 2 );


/**
 *	The content of the options page.
 */
function hmg_options_page() {
	?>
	
	<div class="wrap">
		<?php screen_icon( 'icon_hm-gallery' ); ?><h2><?php _e( 'Gallery Settings', 'hmg' ); ?></h2>
		
		<form method="post" action="options.php">
			<table class="form-table">
							
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Enable Gallery for Post Type', 'hmg' ); ?></strong></th>
					<td>
					<?php 
						$hmg_enable_post_type =  get_option('hmg_post_type', array('hmg-entry') ); 
						$args = array( 'public'   => true, '_builtin' => false );
						$custom_post_types = get_post_types( $args, 'objects' );
					?>	
						<label for="hmg_post_type_post"><input type="checkbox" id="hmg_post_type_post" name="hmg_post_type[]" value="post" <?php hmg_is_checked_post_type( 'post', $hmg_enable_post_type ); ?>/> <?php _e( 'post', 'hmg' ); ?></label><br/>
						<label for="hmg_post_type_page"><input type="checkbox" id="hmg_post_type_page" name="hmg_post_type[]" value="page" <?php hmg_is_checked_post_type( 'page', $hmg_enable_post_type ); ?>/> <?php _e( 'page', 'hmg' ); ?></label><br/>
					<?php 
						foreach( $custom_post_types as $post_type ) { ?>
							<label for="hmg_post_type_<?php echo $post_type->name; ?>"><input type="checkbox" id="hmg_post_type_<?php echo $post_type->name; ?>" name="hmg_post_type[]" value="<?php echo $post_type->name; ?>" <?php hmg_is_checked_post_type( $post_type->name, $hmg_enable_post_type ); ?>/> <?php echo $post_type->name; ?></label><br/>
						<?php }
					?>		
						<small class="description"><?php _e( 'Enable the gallery for other post types.', 'hmg' ); ?></small>
					</td>
				</tr>
								
				<tr valign="top">
					<th scope="row"><strong><?php _e( 'Gallery to set Thumbnail.', 'hmg' ); ?></strong></th>
					<td>
						<label for="hmg_manage_featured">
							<input type="checkbox" name="hmg_manage_featured" id="hmg_manage_featured" value="1" <?php if( get_option('hmg_manage_featured', true) ) echo 'checked="checked"'; ?>>
							<?php _e('Use the gallery box to choose the featured post. The first (highlighted) image will be used.', 'hmg' ); ?> 
						</label>
					</td>
				</tr>
								
			</table>
			
			<input type="hidden" name="action" value="update" />
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			
			<?php 
			settings_fields( 'hmg-settings' );
			
			// Output any sections defined for page sl-settings
			do_settings_sections('hmg-settings'); 
			?>
		</form>
		
		<div id="message">
			<p><small>If you are having any issue with HM Gallery please file a bug or question <a href="https://github.com/mattheu/HM-Gallery" target="_blank">here.</a><small></small></p>
		</div>
	</div>
	<?php
}


//
//	Helper functions
// 
 
function hmg_is_checked_post_type( $post_type, $enabled_post_types ) {
	if( in_array( $post_type, (array) $enabled_post_types ) ) 
		echo 'checked="checked"';
}

function hmg_is_selected_append( $option = 1, $true = 1  ) {
	if( $option == 1 && $true == true || $option == 0 && $selected == false )
		echo 'selected="selected"';
}