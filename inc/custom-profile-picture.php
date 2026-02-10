<?php
/*
Plugin Name: Custom Profile Picture
Description: Permite a los usuarios cambiar su imagen de perfil usando la biblioteca de medios.
Version: 1.0
Author: Tu Nombre
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function custom_profile_picture_fields( $user ) {
    ?>
    <h3><?php _e('Imagen de perfil personalizada', 'custom-profile-picture'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="custom_profile_picture"><?php _e('Imagen de perfil', 'custom-profile-picture'); ?></label></th>
            <td>
                <input type="hidden" name="custom_profile_picture" id="custom_profile_picture" value="<?php echo esc_url( get_the_author_meta( 'custom_profile_picture', $user->ID ) ); ?>" />
                <img id="profile-picture-preview" src="<?php echo esc_url( get_the_author_meta( 'custom_profile_picture', $user->ID ) ); ?>" style="max-width: 200px; height: auto;" />
                <br />
                <input type="button" class="button" value="<?php _e('Seleccionar Imagen', 'custom-profile-picture'); ?>" id="upload_image_button" />
                <p class="description"><?php _e('Selecciona una imagen desde la biblioteca de medios.', 'custom-profile-picture'); ?></p>
            </td>
        </tr>
    </table>
    <script>
    jQuery(document).ready(function($) {
        $('#upload_image_button').click(function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Seleccionar Imagen',
                button: { text: 'Usar esta imagen' },
                multiple: false
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#custom_profile_picture').val(attachment.url);
                $('#profile-picture-preview').attr('src', attachment.url);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

function save_custom_profile_picture( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'custom_profile_picture', $_POST['custom_profile_picture'] );
}

add_action( 'show_user_profile', 'custom_profile_picture_fields' );
add_action( 'edit_user_profile', 'custom_profile_picture_fields' );
add_action( 'personal_options_update', 'save_custom_profile_picture' );
add_action( 'edit_user_profile_update', 'save_custom_profile_picture' );

function custom_profile_picture_display( $user_id ) {
    $profile_picture = get_the_author_meta( 'custom_profile_picture', $user_id );
    if ( $profile_picture ) {
        return '<img src="' . esc_url( $profile_picture ) . '" class="avatar avatar-96 photo" height="96" width="96" />';
    } else {
        return get_avatar( $user_id, 96 );
    }
}
