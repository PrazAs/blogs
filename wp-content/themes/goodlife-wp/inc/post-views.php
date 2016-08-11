<?php
//Get Page View Count
function thb_post_viewcount( $id ) {
    
    if ( function_exists( 'stats_get_csv' ) ) {
				$id = $id ? $id : get_the_ID();
				
				$args = 'days=-1&post_id=' . $id;
        $cache = 'thb_postviews_count_' . $id;
        
        if ( ( $count = get_transient( $cache ) ) === false ) {
            $count = stats_get_csv( 'postviews', $args );
           
            set_transient( $cache, $count, 180 ); 
            update_post_meta($id, $cache, $count); 
        }
		
        if ( $count[0]['views'] != NULL ) {
            echo thb_numberAbbreviation(esc_attr($count[0]['views']));
        } else {
            echo '0';
        }
    } else {
        return NULL;
    }
}
add_action( 'thb_post_viewcount', 'thb_post_viewcount', 10, 1 );

//Most Viewd
function thb_most_viewed( $time = 7, $numPosts = 5) {
    
    if ( function_exists( 'stats_get_csv' ) ) {
				$id = get_the_ID();
				
				 if ( $time == 7 ) {
				
            $cache = 'thb_most_viewed_week_'.$numPosts;
            if ( ( $posts = get_transient( $cache ) ) === false ) {
                $posts = stats_get_csv( 'postviews', 'days=7&limit='.($numPosts + 2).'&summarize' );
                set_transient($cache, $posts, 300);  
            }
            
        } else if ( $time == 30 ) {

            $cache = 'thb_most_viewed_month_'.$numPosts;
            if ( ( $posts = get_transient( $cache ) ) === false ) {
                $posts = stats_get_csv( 'postviews', 'days=31&limit='.($numPosts + 2).'&summarize' );
                set_transient($cache, $posts, 300);  
            }
            
        } else if ( $time == 365 ) {

            $cache = 'thb_most_viewed_all_'.$numPosts;
            if ( ( $posts = get_transient( $cache ) ) === false ) {
                $posts = stats_get_csv( 'postviews', 'days=-1&limit='.($numPosts + 2).'&summarize' );
                set_transient($cache, $posts, 300);  
            }

        }
				$post_ids = array_map(function($n) {
					return $n['post_id'];
				},$posts);
       	return array_slice($post_ids, 0, $numPosts);
        
    } else {
        return NULL;
    }
}