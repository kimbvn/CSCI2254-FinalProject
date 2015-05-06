<?php
/*
Plugin Name: Site Plugin for BC KISA

Description: Site specific code changes for example.com

*/

add_image_size( 'album-grid', 225, 150, true );

add_action( 'init', 'register_cpt_album' );

function register_cpt_album() {

    $labels = array( 
        'name' => _x( 'Albums', 'album' ),
        'singular_name' => _x( 'Album', 'album' ),
        'add_new' => _x( 'Add New', 'album' ),
        'add_new_item' => _x( 'Add New Album', 'album' ),
        'edit_item' => _x( 'Edit Album', 'album' ),
        'new_item' => _x( 'New Album', 'album' ),
        'view_item' => _x( 'View Album', 'album' ),
        'search_items' => _x( 'Search Albums', 'album' ),
        'not_found' => _x( 'No albums found', 'album' ),
        'not_found_in_trash' => _x( 'No albums found in Trash', 'album' ),
        'parent_item_colon' => _x( 'Parent Album:', 'album' ),
        'menu_name' => _x( 'Albums', 'album' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        'menu_icon' => 'Albums',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'album', $args );
}
 function display_child() {
 	global $post;
 		if( is_page() && $post->post_parent) {
 			$childpages = wp_list_pages('sort_colun=menu_order&title_li=&child_of=' .$post-
 			>post_parent .'&echo=0');
 		} else {
 			$childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' .$post->ID .
 			'&echo=0');
 		}
 		if($childpages) {
 	 		$string = '<ul>'.$childpages.'</ul'>;
 	 	}
 	 	return $string;
 	}
 	add_shortcode('wpb_childpages','wpb_list_child_pages');

function displaysoccer() {
	echo "<div style=\"float:bottom; text-align:center\">";
	echo "<form name=\"form\" method=\"post\"  onsubmit=\"return validate();\">";
	echo "<table>
			<tr>
				<td> Number of Players From BC: </td>
				<td><input type=\"text\" name=\"players\" id=\"name\"/></td>
				<td><span class=\"ereport\" id=\"playerserror\"></span></td>
			</tr>
			<tr>
				<td> Name of the School : </td>
				<td><input type=\"text\" name=\"school\" id=\"category\"/></td>
				<td><span class=\"ereport\" id=\"schoolerror\"></span></td>
			</tr>
			<tr>
				<td> Number of Players From Other School: </td>
				<td><input type=\"text\" name=\"number2\" id=\"name\"/></td>
				<td><span class=\"ereport\" id=\"number2error\"></span></td>
			</tr>
			<tr>
				<td> Phone Number of the Captain: </td>
				<td><input type=\"text\" name=\"phone\" id=\"phone\"/></td>
				<td><span class=\"ereport\" id=\"phoneerror\"></span></td>
			</tr>
			<tr>
				<td> Date of the Game: </td>
				<td><input type=\"date\" name=\"date\" id=\"date\"/></td>
				<td><span class =\"ereport\" id=\"dateerror\"></span></td>
			</tr>
			<tr>
				<td> Address: </td>
				<td><input type=\"text\" name=\"address\" id=\"address\"/></td>
				<td><span class=\"ereport\" id=\"addresserror\"></span></td>
			</tr>
			<tr>
				<td> Comment: </td>
				<td><textarea name=\"comment\" cols=\"50\" rows=\"10\" id=\"comment\"> </textarea></td>
				<td> <span class=\"ereport\" id=\"commenterror\"></span></td>
			</tr>
			<tr>
				<td></td>
				<td><input type=\"submit\" name=\"submit\" value=\"Add\" /></td>
				<td></td>
			</tr>
		</table></div>";		
	echo "</form>";
	}
	add_shortcode('soccerform','displaysoccer');






function handlesoccer() {

	
	$name = $_POST['players'];
	$star = $_POST['school'];
	$price = $_POST['number2'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$comment = mysql_real_escape_string($_POST['comment']);
	

   	$geocodeURL = "https://maps.googleapis.com/maps/api/geocode/xml?";
   	$urladdress = "address=" . urlencode($address);
   	$key = "AIzaSyC0l5lpV9qWcYUuxB2jbSw3gMuyumBfs5g";
	$geocoderequest = "$geocodeURL$urladdress" . "&" . $key;
		
   	$xml= new SimpleXMLElement( file_get_contents( $geocoderequest ) );
   		
   	if($xml->status != 'OK') {
   		header("Location: index.php?status=$xml->error_message");
   		$status = $xml->error_message;
   		die("bad result status $status");
   	}

    $latitude  = $xml->result->geometry->location->lat;
    $longitude = $xml->result->geometry->location->lng;
        
    if(insertform($name,$star,$price,$category,$address,$phone,$url,$userid,$comment,$latitude,$longitude)) {
    	header('Location: index.php?status=goodinsert');
    } else {
    	header('LocationL index.php?status=badaddr');
    }

}
add_shortcode('soccermap','handlesoccer');

?>
