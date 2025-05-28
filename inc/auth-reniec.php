<?php

namespace ReniecIdaasAuth;

use Reniec\Idaas\ReniecIdaasClient;

class Reniec_Auth
{
    private $api_helper;
    private $auth_client;

    public function __construct()
    {
        $this->api_helper = new Reniec_Api_Helper();
        $config = $this->api_helper->get_config();

        if (
            $config && is_array($config) &&
            !empty($config['client_id']) && is_string($config['client_id']) &&
            !empty($config['client_secret']) && is_string($config['client_secret']) &&
            !empty($config['redirect_uri']) && is_string($config['redirect_uri'])
        ) {
            try {
                $temp_config = [
                    'client_id' => $config['client_id'],
                    'client_secret' => $config['client_secret'],
                    'auth_uri' => $config['redirect_uri'],
                    'token_uri' => 'https://idaas.reniec.gob.pe/token',
                    'userinfo_uri' => 'https://idaas.reniec.gob.pe/userinfo',
                    'logout_uri' => 'https://idaas.reniec.gob.pe/logout'
                ];

                $temp_file = sys_get_temp_dir() . '/reniec_idaas_' . uniqid() . '.json';
                file_put_contents($temp_file, json_encode($temp_config));

                $this->auth_client = new ReniecIdaasClient($temp_file);

                $redirect_uri = get_option('reniec_redirect_uri', '');
                if (!empty($redirect_uri) && is_string($redirect_uri)) {
                    $this->auth_client->setRedirectUri($redirect_uri);
                } else {
                    error_log('Error RENIEC: redirect_uri de get_option está vacío o no es una cadena');
                    $this->auth_client = null;
                }

                $this->auth_client->addScope('openid');
                $this->auth_client->addScope('doc');
                $this->auth_client->addScope('first_name');

                unlink($temp_file);
            } catch (\Exception $e) {
                error_log('Error al inicializar ReniecIdaasClient: ' . $e->getMessage());
                $this->auth_client = null;
            }
        } else {
            error_log('Error de configuración RENIEC: Uno o más valores (client_id, client_secret, redirect_uri) están vacíos o no son cadenas');
            $this->auth_client = null;
        }
    }

    public function get_auth_url()
    {
        if (!$this->auth_client) {
            error_log('Error RENIEC: Cliente no inicializado debido a configuración inválida');
            return '#';
        }

        try {
            $state = bin2hex(random_bytes(16));

            $_SESSION['reniec_state'] = $state;

            $this->auth_client->setState($state);

            $auth_url = $this->auth_client->getLoginUrl();
            return $auth_url;
        } catch (\Exception $e) {
            error_log('Error al generar URL de autorización RENIEC: ' . $e->getMessage());
            return '#';
        }
    }
}
