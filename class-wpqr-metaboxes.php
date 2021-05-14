<?php

if( ! defined( 'ABSPATH' ) ) {
    return;
}
class WPQR_Metaboxes {

    /**
     * Renders the metabox for answers.
     * We will display saved answers and have the form to add new or delete old.
     *
     * @param  WP_Post $post
     * @return void       
     */
    public static function answers( $post ) {
        $post_id = $post->ID;
        // Get our answers
        $answers = get_post_meta( $post_id, '_wpqr_answers', true );
        ?>
        <table class="wpqr-answers form-table">
            <thead>
                <tr>
                    <td><strong><?php esc_html_e( 'Answer', 'wpqr' ); ?></strong></td>
                    <td><strong><?php esc_html_e( 'Points', 'wpqr' ); ?></strong></td>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ( $i = 0; $i < 3; $i++ ) {
                        ?>
                        <tr>
                            <td><input type="text"   name="wpqr_answers[]" value="<?php echo isset( $answers[ $i ] ) && $answers[ $i ]['text'] ? $answers[ $i ]['text'] : ''; ?>" class="widefat"/></td>
                            <td><input type="number" name="wpqr_points[]" value="<?php echo isset( $answers[ $i ] ) && $answers[ $i ]['points'] ? $answers[ $i ]['points'] : 0; ?>"/></td>
                        </tr>
                        <?php
                    }
                ?> 
            </tbody> 
        </table>
        <?php
    }
}
