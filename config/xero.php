<?php

return [
    /*
    * set the client id
    */
    'clientId' => env('XERO_CLIENT_ID', '705F0933E75A421693F618BC96125E2E'),

    /*
    * set the client secret
    */
    'clientSecret' => env('XERO_CLIENT_SECRET', 'z6wjTda6RYB-s8DgdsX2nfjcVt83z0naeUd99i8UfTbsMgnl'),

    /*
    * Set the url to trigger the oauth process
    */
    'redirectUri' => env('XERO_REDIRECT_URL', 'https://portal.kaolin-towing.com/xero'),

    /*
    * Set the url to redirecto once authenticated;
    */
    'landingUri' => env('XERO_LANDING_URL', 'https://portal.kaolin-towing.com/'),

    /**
     * Set access token, when set will bypass the oauth2 process
     */
    'accessToken' => env('XERO_ACCESS_TOKEN', ''),

    /**
     * Set webhook token
     */
    'webhookKey' => env('XERO_WEBHOOK_KEY', ''),

    /**
     * Set the scopes
     */
    'scopes' => env('XERO_SCOPES', 'openid email profile offline_access accounting.settings accounting.transactions accounting.contacts'),

    /**
     * Encrypt tokens in database?
     */
    'encrypt' => env('XERO_ENCRYPT', true),
];
