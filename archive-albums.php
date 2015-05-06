<!DOCTYPE html>
<html lang="en">
.album-grid{width: 225px; height: 150px; float: left; list-style: none; list-style-type: none; margin: 0 18px 30px 0px;}


	
	</html>

<?php


if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 

<li class="album-grid"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('album-grid'); ?></a></li>

 

<?php if ( $post->post_type == 'albums' && $post->post_status == 'publish' ) {

        $attachments = get_posts( array(

            'post_type' => 'attachment',

            'posts_per_page' => -1,

            'post_parent' => $post->ID,

            'exclude'     => get_post_thumbnail_id()

        ) );

 

        if ( $attachments ) {

            foreach ( $attachments as $attachment ) {

                $class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );

                $title = wp_get_attachment_link( $attachment->ID, 'album-grid', true );

                echo '<li class="' . $class . ' album-grid">' . $title . '</li>';

            }

             

        }

    }
    
    	} // end while
} // end if


?>
