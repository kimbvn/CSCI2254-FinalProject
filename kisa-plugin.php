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

function be_attachment_field_credit( $form_fields, $post ) {

    $form_fields['hashtag'] = array(

        'label' => 'hashtag#',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'hashtag', true ),
        'helps' => 'Add #hashtags!',
    );
 
 
    return $form_fields;

}


add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

/**

 * Save values of hashtags in media uploader

 * @param $post array, the post data for database

 * @param $attachment array, attachment fields from $_POST form

 * @return $post array, modified post data

 */

function be_attachment_field_credit_save( $post, $attachment ) {

    if( isset( $attachment['hashtag'] ) )
        update_post_meta( $post['ID'], 'hashtag', $attachment['hashtag'] );
 
    return $post;
}
 

add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );


/*
 * Displays a list of child pages under a paent page, KISA YOUTUBE
 */
 
 function display_child() {
 	global $post;
 		if( is_page() && $post->post_parent) {
 			$childpages = wp_list_pages('sort_colun=menu_order&title_li=&child_of=' .$post->
 			post_parent .'&echo=0');
 		} else {
 			$childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' .$post->ID .
 			'&echo=0');
 		}
 		if($childpages) {
 	 		 $string = '<ul>' . $childpages . '</ul>';

 	 	}
 	 	echo $string;
 	}
 	add_shortcode('wpb_childpages','display_child');
 	add_filter('widget_text','do_shortcode');
/*
function getweather(){
	$weatherlocs = "http://w1.weather.gov/xml/current_obs/KBOS.xml"
	$xml = new SimpleXMLElement(file_get_contents("boston"));
	$location = $xml->location;
	$temp = $xml->temp_f;
	$visibility = $xml->visibility_mi;
	$time = $xml->observation_time;
	echo "<h2>The weather of $location</h2>";
	echo "Temperature is $temp'F and the visibility is $visibility<br>";
	echo "$time";

}


add_shortcode('weather','getweather');
*/


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



if(isset($_POST['submit'])) {
	handlesoccer();
	}


function handlesoccer() {

	
	$plyers = $_POST['players'];
	$school = $_POST['school'];
	$players2 = $_POST['number2'];
	$address = $_POST['address'];
	$date = $_POST['date'];
	$phone = $_POST['phone'];
	$comment = mysql_real_escape_string($_POST['comment']);
    
    
    $location = handleForm($address);
	$latitude = $location["latitude"];
	$longitude = $location["longitude"];
        
    if(insertform($players,$school,$players2,$address,$date,$phone, $latitude, $longitude, $comment)) {
		echo "Insertion done";
    } else {
    	echo "Insertion failed";
    }
    
    
}

	function handleForm($address){
		//echo "<fieldset><legend>Info about $address</legend>";

   		$geocodeURL = "https://maps.googleapis.com/maps/api/geocode/xml?";
   		$address = "address=" . urlencode($address);
   		// https://console.developers.google.com
   		$key = "AIzaSyASZREptljJNANdLCrRZ-DCZq0cKhcpwGU";
   		$geocoderequest = "$geocodeURL$address" . "&" . $key;
   		
   		//die( "The url is >" . $geocoderequest . "<" );
   		
   		$xml= new SimpleXMLElement( file_get_contents( $geocoderequest ) );
   		
   		if($xml->status != 'OK') {
   			$status = $xml->error_message;
   			die("bad result status $status");
   		}

		$placeRequestURL = "https://maps.googleapis.com/maps/api/place/details/xml?";
   		//$key = "key=AIzaSyAsAWbQ0_nFCSoOwOwVP9JYroJ12JI0xOE";
   		$placeID = "placeid=" . $xml->place_id;
   		$placedetailsrequest = "$placeRequestURL$placeID" . "&" . $key;
   		
   		//echo $placedetailsrequest;
   		
   		$xml2 = new SimpleXMLElement( file_get_contents( $geocoderequest ) );
   		$loc = getLocation($xml);
   		return ($loc);


	}

    function getLocation($xml)
    {
        //echo "<pre>"; print_r( $xml);  	echo "</pre>";
        $latitude  = $xml->result->geometry->location->lat;
        $longitude = $xml->result->geometry->location->lng;
        
        $location = array("latitude" => $latitude, "longitude" => $longitude);
        
        return ($location);
    }



function connectToDB() {
	$dbc = @mysqli_connect("localhost","kimbvn","agTKw48F","kimbvn") or
		die("Connect failed:".mysqli_connect_error());
	return ($dbc);
}

function disconnectFromDB($dbc,$result) {
	mysqli_free_result($result);
	mysqli_close($dbc);
}

function performQuery($dbc,$query) {
	$result = mysqli_query($dbc,$query) or die("bad query".mysqli_error($dbc));
	return ($result);
}

function insertform($players,$school,$players2,$address,$date,$phone,$latitude, $longitude, $comment) {
	$dbc = connectToDB();
	$query = "INSERT INTO KISASoccer VALUES(\"$players\",\"$school\",\"$players2\",
				\"$address\",\"$date\",\"$phone\", \"$latitude\", \"$longitude\", \"$comment\")";
	$result = performQuery($dbc,$query);
	if($result == 1) {
		return true;
		
	} else {
		return false;
	}
}

function displaysoccerschedule() {
	$dbc = connectToDB();
	$query = "SELECT * FROM KISASoccer";
	$selection = performQuery($dbc,$query);
	$result = performQuery($dbc,$query);
	
	
	$weatherlocs = array (
		"BU" => "http://w1.weather.gov/xml/current_obs/KBOS.xml",
		"Babson" => "http://w1.weather.gov/xml/current_obs/BHBM3.xml",
		"Harvard" => "http://w1.weather.gov/xml/current_obs/KBOS.xml",
		"MIT" => "http://w1.weather.gov/xml/current_obs/KBOS.xml",
		"Brown" => "http://w1.weather.gov/xml/current_obs/KPVD.xml",
		"NYU" => "http://w1.weather.gov/xml/current_obs/KNYC.xml",
		"CORNELL" => "http://w1.weather.gov/xml/current_obs/KITH.xml",
		"UPENN" => "http://w1.weather.gov/xml/current_obs/KPHL.xml"
		 );
	
	
	
	
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	echo "<table id=\"result\" style=\"background-color: #F5F6CE\">
			<tr>
				<th>Date</th>
				<th>BC Players</th>
				<th>Opposing Team</th>
				<th>Players</th>
				<th>Address </th>
				<th>Phone</th>
				<th>Comment</th>
				<th> Weather </th>
				<th> Temperature </th>
				
			</tr>";
			
	while($row = mysqli_fetch_array($selection,MYSQLI_ASSOC)) {
		$date = $row['Date'];
		$players = $row['Players'];
		$school = $row['School'];
		$players2 = $row['Players2'];
		$address = $row['Address'];
		$phone = $row['Phone'];
		$comment = $comment['Comment'];
		$weather= getWeather($weatherlocs, $school);
		$temp = getTemperature($weatherlocs, $school);

		echo "<tr>
				<td>$date </td>
				<td>$players</td>
				<td>$school</td>
				<td>$players2</td>
				<td>$address</td>
				<td>$phone</td>
				<td>$comment</td>
				<td> $weather </td>
				<td> $temp </td>
			</tr>";
	} 
	echo "</table>";
}

add_shortcode('soccerschedule','displaysoccerschedule');



function getWeather($weatherlocs, $school) {

		$city = $_GET['location'];
		$file = $weatherlocs[$school];
			
		if ( ! ($xmlstr = file_get_contents($file)) ) {
			die("Unable to read XML file $file" );
			}
		else { $xmlstr = file_get_contents($file); }
		
		
		$xml = new SimpleXMLElement( $xmlstr );	
		
		
		$weather = $xml -> weather;		
		
		return $weather ;
		
	
		}
		
function getTemperature($weatherlocs, $school) {

		$city = $_GET['location'];
		$file = $weatherlocs[$school];
			
		if ( ! ($xmlstr = file_get_contents($file)) ) {
			die("Unable to read XML file $file" );
			}
		else { $xmlstr = file_get_contents($file); }
		
		
		$xml = new SimpleXMLElement( $xmlstr );	
		
		$temperature = $xml -> temperature_string;

		
		
		return $temperature;
		

	
		}
		
		function joinSoccerTeam() {
	echo "<form name=\"form\" method=\"post\"  onsubmit=\"return validate2();\">";
	echo "<table>
			<tr>
				<td> Name: </td>
				<td><input type=\"text\" name=\"name\" id=\"name\"/></td>
				<td><span class=\"ereport\" id=\"nameerror\"></span></td>
			</tr>
			<tr>
				<td> Position </td>
				<td><select name=\"position\" id=\"position\">
					<option></option>
					<option value=\"captain\"> Captain </option>
					<option value=\"goal\"> Goalkeeper </option>
					<option value=\"centerback\"> Center-Back </option>
					<option value=\"fullback\"> Full-Back </option>
					<option value=\"wingback\"> Wing-back </option>
					<option value=\"midfielder\"> Midfielder </option>
					<option value=\"striker\"> Striker </option>
					<option value=\"forward\"> Forward </option>
					</select> </td>
				<td><span class=\"ereport\" id=\"positionerror\"></span></td>
			</tr>
			
			<tr>
				<td> Phone: </td>
				<td><input type=\"text\" name=\"phone\" id=\"phone\"/></td>
				<td><span class=\"ereport\" id=\"phoneerror\"></span></td>
			</tr>
			<tr>
				<td> Class: </td>
				<td><input type=\"text\" name=\"class\" id=\"class\"/></td>
				<td><span class=\"ereport\" id=\"classerror\"></span></td>
			</tr>
			<tr>
				<td> Comment: </td>
				<td><textarea name=\"comment\" cols=\"50\" rows=\"10\" id=\"comment\"> </textarea></td>
				<td> <span class=\"ereport\" id=\"commenterror\"></span></td>
			</tr>
			<tr>
				<td></td>
				<td><input type=\"submit\" name=\"submit2\" value=\"Add\" /></td>
				<td></td>
			</tr>
		</table>";		
	echo "</form>";
}
add_shortcode('joinsoccer','joinSoccerTeam');
if(isset($_POST['submit2'])) {
	handlejoin();
}

function handlejoin() {
	
	$name = $_POST['name'];
	$position = $_POST['position'];
	$phone = $_POST['phone'];
	$class = $_POST['class'];
	$comment = mysql_real_escape_string($_POST['comment']);
	
	 if(joinsoccer($name,$position,$phone,$class,$comment)) {
		echo "Insertion done";
    } else {
    	echo "Insertion failed";
    }
    
}	

function joinsoccer($name,$position,$phone,$class,$comment) {
	$dbc = connectToDB();
	$query = "INSERT INTO JOINSOCCER VALUES(\"$name\",\"$position\",\"$phone\",
				\"$class\", \"$comment\")";
	$result = performQuery($dbc,$query);
	if($result == 1) {
		return true;
		
	} else {
		return false;
	}
}

function soccerteam() {
	$dbc = connectToDB();
	$query = "SELECT * FROM JOINSOCCER";
	$selection = performQuery($dbc,$query);
	$result = performQuery($dbc,$query);
	
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	echo "<table>
			<tr>
				<th>Name</th>
				<th>Position</th>
				<th>Phone</th>
				<th>Class</th>
				<th>Comment</th>
			
			</tr>";
	while($row = mysqli_fetch_array($selection,MYSQLI_ASSOC)) {
		$name = $row['Name'];
		$position = $row['Position'];
		$phone = $row['Phone'];
		$class = $row['Class'];
		$comment = $row['Comment'];

		echo "<tr>
				<td>$name</td>
				<td>$position</td>
				<td>$phone</td>
				<td>$class</td>
				<td>$comment</td>
			</tr>";
	} 
	echo "</table>";

}
add_shortcode('showteam','soccerteam');
?>
?>
