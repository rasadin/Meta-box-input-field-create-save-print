function eb_pdf_link_add_a_metabox() {
	add_meta_box(
		'eb_pdf_link_metabox', // metabox ID, it also will be the HTML id attribute
		'EB PDF Link 2 Metabox', // title
		'eb_pdf_link_display_metabox', // this is a callback function, which will print HTML of our metabox
		'post', // post type or post types in array
		'normal', // position on the screen where metabox should be displayed (normal, side, advanced)
		'default' // priority over another metaboxes on this page (default, low, high, core)
	);
}
 
add_action( 'admin_menu', 'eb_pdf_link_add_a_metabox' );

function eb_pdf_link_display_metabox( $post ) {
	/*
	 * needed for security reasons
	 */
	wp_nonce_field( basename( __FILE__ ), 'eb_pdf_link_metabox_nonce' );
	/*
	 * text field
	 */
	$html = '<p><label>PDF2 Link Input: <input type="text" name="eb_pdf_link_title" value="' . esc_attr( get_post_meta($post->ID, 'eb_pdf_link_title',true) )  . '" /></label></p>';
	/*
	 * print all of this
	 */
	echo $html;
}

function eb_pdf_link_save_post_meta( $post_id, $post ) {
	/* 
	 * Security checks
	 */
	if ( !isset( $_POST['eb_pdf_link_metabox_nonce'] ) 
	|| !wp_verify_nonce( $_POST['eb_pdf_link_metabox_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	/* 
	 * Check current user permissions
	 */
	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	/*
	 * Do not save the data if autosave
	 */
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
 
	if ($post->post_type == 'post') { // define your own post type here
		update_post_meta($post_id, 'eb_pdf_link_title', sanitize_text_field( $_POST['eb_pdf_link_title'] ) );
		update_post_meta($post_id, 'eb_pdf_link_noindex', $_POST['eb_pdf_link_noindex']);
	}
	return $post_id;
}
add_action( 'save_post', 'eb_pdf_link_save_post_meta', 10, 2 );
