<?php
function getConfig ($service) {
    $gatewayConfig = [
        'tenant_token_kho_local' => '', // local KHO
        'tenant_token_kho_production' => '', // production KHO
        'tenant_token_kho_staging' => '', // staging KHO
    ];

    $gatewayConfig['services'] = [
        'categories' => [
            'endpoint' => 'https://gateway.jma-web.net/product/api/v1',
            'access_token' => '',
            'tenant_token' => $gatewayConfig['tenant_token_kho_production'],
        ],
        'contacts' => [
            'endpoint' => 'http://localhost:8081/api',
            'access_token' => '',
            'tenant_token' => $gatewayConfig['tenant_token_kho_local'],
        ]
    ];

    return $gatewayConfig['services'][$service];
}
