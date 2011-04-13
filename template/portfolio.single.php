<?php 
//add_filter( 'the_content', 'hmp_single_content' );
function hmp_single_content( $content ) {
	global $post;
	
	ob_start();
	dynamic_sidebar('Portfolio Single');
	$sidebar = ob_get_contents();
	ob_end_clean(); 
	return $sidebar;
}
?>
<?php 
if( get_option( 'hmp_use_styles', 'on' ) ) {
	wp_enqueue_style( 'hmp-portfolio', HMPURL . 'template/styles/style.css' );
	wp_enqueue_style( 'lightbox.css', HMPURL . 'template/styles/jquery.lightbox-0.5.css' );
}
if( get_option( 'hmp_use_scripts', 'on' ) ) {
	wp_enqueue_script( 'lightbox', HMPURL . 'template/js/jquery.lightbox-0.5.min.js', array( 'jquery' ) );
}
if( file_exists( $file = get_template_directory() . '/single.php' ) ) {
	include( $file );  
} else {
	include( get_template_directory() . '/index.php' );
}
?>