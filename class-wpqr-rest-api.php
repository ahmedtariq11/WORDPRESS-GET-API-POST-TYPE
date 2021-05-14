<?php

if( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Class used to define how rest api works.
 */
class WPQR_REST_API {

    /**
     * Registering routes
     * @return void 
     */
    public static function register_routes() {
        register_rest_route( 'wpqr/v1', '/questions', array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => array( __CLASS__, 'get_questions' ),
        ) ); 
    }

    /**
     * Get the Questions with answers for the REST API Route
     * @return mixed 
     */
    public static function get_questions() {

        $questions = get_transient( 'wpqr_rest_questions' );
     
        if ( false === $questions ) {
            $questions = array();
                
            $args = array(
                
                //Type & Status Parameters
                'post_type'   => 'question',
                'post_status' => 'publish',
                
                //Order & Orderby Parameters
                'order'               => 'ASC',
                'orderby'             => 'date', 
                
                //Pagination Parameters
                'posts_per_page'         => 500,
                
                //Parameters relating to caching
                'no_found_rows'          => true,
                'cache_results'          => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            );
            // Get all the questions.
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                while( $query->have_posts() ) {
                    $query->the_post();
                    $q_array = array();
                    $q_array['id'] = get_the_id();
                    $q_array['title'] = get_the_title();
                    $q_array['content'] = get_the_content();
                    $q_array['answers'] = get_post_meta( get_the_id(), '_wpqr_answers', true );
                    
                    if ( is_array( $q_array['answers'] ) ) {
                        // Filter and return only the answer text.
                        // By including points, the user could know which gives more points using console
                        $q_array['answers'] = array_map( 
                            function( $item ) {  
                                return $item['text'];
                            },
                            $q_array['answers']);
                    }

                    if ( $q_array['answers'] ) {
                        $questions[] = $q_array;
                    }
                }
                wp_reset_postdata();
            }

            set_transient( 'wpqr_rest_questions', $questions, 24 * HOUR_IN_SECONDS );
        }

        return $questions;
    }
}
