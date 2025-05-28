<?php

use ReniecIdaasAuth\Reniec_Auth;

function reniec_button_shortcode()
{

    $auth = new Reniec_Auth();
    $auth_url = $auth->get_auth_url();
?>
    <div class="reniec-auth-wrapper">
        <a href="<?php echo esc_url($auth_url); ?>" class="reniec_boton">RENIEC IDaaS</a>
    </div>
<?php
}
add_shortcode('reniec_auth_button', 'reniec_button_shortcode');
