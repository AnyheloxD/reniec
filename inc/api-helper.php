<?php

namespace ReniecIdaasAuth;

class Reniec_Api_Helper
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    public function __construct()
    {
        $this->client_id = get_option('reniec_client_id');
        $this->client_secret = get_option('reniec_client_secret');
        $this->redirect_uri = get_option('reniec_redirect_uri');
    }

    public function get_config()
    {
        if (empty($this->client_id) || empty($this->client_secret) || empty($this->redirect_uri)) {
            return false;
        }
        return [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
        ];
    }
}
