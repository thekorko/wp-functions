<?php
/*
First as described in the wordpress docs
https://developer.wordpress.org/plugins/javascript/enqueuing/
Enqueue my custom jquery, as an ajax script
Also localize, create_nonce and register de ajax url
Ver 0.1
wp_enqueue_script is for the frontend there are other options
https://quartex.net
TheKorko
*/
add_action( 'wp_enqueue_scripts', 'my_enqueue' );
function my_enqueue() {
   wp_enqueue_script(
      'ajax-script',
      get_template_directory_uri() . '/js/myjquery.js',
      array( 'jquery' ),
      '1.0.0',
      true
   );
   $upvote_nonce = wp_create_nonce( 'upvote_example' );
   wp_localize_script(
      'ajax-script',
      'my_ajax_obj',
      array(
         'ajax_url' => admin_url( 'admin-ajax.php' ),
         'nonce'    => $upvote_nonce,
      )
   );
}
/*
* Response example for upvote ver 0.1
* Lacks validation/sanitization (This is just a test)
*/
add_action( 'wp_ajax_upvote_post', 'my_upvote' );
function my_upvote() {
	 //check if user has voted already
   check_ajax_referer( 'upvote_example' );
	 $post_meta = get_post_meta( $_POST['post_id'], 'karma', true);
	 if (!$post_meta or $post_meta==0) {
	 $post_meta = 1;
	 $update = add_post_meta($_POST['post_id'], 'karma', $post_meta, true);
	 } else {
		$post_meta = intval($post_meta)+1;
	  $update = update_post_meta( $_POST['post_id'], 'karma', $post_meta);
	 }
	 echo $post_meta;
   wp_die(); // all ajax handlers should die when finished
}
?>
