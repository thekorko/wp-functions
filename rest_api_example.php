<?
//Use within functions.php context or whenever you'll like to initialize

//Taken from stackoverflow, return auth errors for non authenticated users.
add_filter( 'rest_authentication_errors', function( $result ) {
     // If a previous authentication check was applied,
     // pass that result along without modification.
     if ( true === $result || is_wp_error( $result ) ) {
         return $result;
     }

     // No authentication has been performed yet.
     // Return an error if user is not logged in.
     if ( ! is_user_logged_in() ) {
         return new WP_Error(
             'rest_not_logged_in',
             __( 'You are not currently logged in.' ),
             array( 'status' => 401 )
         );
     }

     // Our custom authentication check should have no effect
     // on logged-in requests
     return $result;
 });
//Checks if user is a API member
function qtx_is_API() {
	if (is_user_logged_in()) {
		$user = wp_get_current_user();
		$staff_roles = array('userAPI');
		if ((array_intersect($staff_roles, $user->roles))) {
			return True;
		}
	}
    return false;
}
//Removes REST API endpoints for non authorized USER
 function qtx_removes_api_endpoints_for_not_API() {

    if ( !qtx_is_API() ) {

        // Removes WordpPress endpoints:
        remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );

        // Removes Woocommerce endpoints if exists
        if ( function_exists('WC') ) {
            remove_action( 'rest_api_init', array( WC()->api, 'register_rest_routes' ), 10 );
        }

    }
}
add_action('init', 'qtx_removes_api_endpoints_for_not_API');
