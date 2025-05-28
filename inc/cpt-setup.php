<?php

// creacion de menu
function reniec_auth_register_settings()
{
    add_menu_page(
        'RENIEC IDaaS',
        'RENIEC Auth',
        'manage_options',
        'reniec-auth-settings',
        'reniec_auth_settings_page'
    );


    register_setting('reniec_auth_group', 'reniec_client_id');
    register_setting('reniec_auth_group', 'reniec_client_secret');
    register_setting('reniec_auth_group', 'reniec_redirect_uri');
}
add_action('admin_menu', 'reniec_auth_register_settings');


function reniec_auth_settings_page()
{
?>
    <div class="wrap">
        <h1>RENIEC IDaaS </h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('reniec_auth_group');
            do_settings_sections('reniec_auth_group');
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="reniec_client_id">Client ID</label></th>
                    <td><input type="text" name="reniec_client_id" id="reniec_client_id"
                            value="<?php echo esc_attr(get_option('reniec_client_id')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="reniec_client_secret">Client Secret</label></th>
                    <td><input type="text" name="reniec_client_secret" id="reniec_client_secret"
                            value="<?php echo esc_attr(get_option('reniec_client_secret')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="reniec_redirect_uri">Redirect URI</label></th>
                    <td><input type="url" name="reniec_redirect_uri" id="reniec_redirect_uri"
                            value="<?php echo esc_attr(get_option('reniec_redirect_uri')); ?>" class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
