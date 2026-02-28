<?php

return [
    'walls_destroyed' => '¡paredes destruidas!',
    'url_placeholder' => 'Ingrese URL (ej: https://ejemplo.com)',
    'analyze_button' => 'Analizar',
    'nav_integration' => 'Integraciones',
    'nav_extension' => 'Instalar',
    'bookmarklet_title' => 'Agregar a Favoritos',
    'bookmarklet_description' => 'Arrastra el botón a tu barra de favoritos para acceder rápidamente en cualquier página:',
    'open_in' => 'Abrir en {site_name}',
    'adblocker_warning' => 'Los conflictos entre {site_name} y los bloqueadores de anuncios pueden causar una pantalla en blanco. Use el modo incógnito o desactive la extensión.',
    'add_as_app' => 'Agregar como aplicación',
    'add_as_app_step1' => 'En su navegador, haga clic en el icono de menú (tres puntos)',
    'add_as_app_step2' => 'Seleccione "Instalar aplicación" o "Agregar a la pantalla de inicio"',
    'add_as_app_step3' => 'Haga clic en "Instalar" para tener acceso rápido',
    'add_as_app_step4' => 'Ahora puede compartir directamente enlaces a {site_name}',
    
    'messages' => [
        'BLOCKED_DOMAIN' => [
            'message' => 'Este dominio está bloqueado para extracción.',
            'type' => 'error'
        ],
        'DMCA_DOMAIN' => [
            'message' => 'El sitio web solicitado no se puede mostrar debido a las solicitudes de sus propietarios.',
            'type' => 'error'
        ],
        'DNS_FAILURE' => [
            'message' => 'Error al resolver DNS para el dominio. Verifique si la URL es correcta.',
            'type' => 'warning'
        ],
        'HTTP_ERROR' => [
            'message' => 'El servidor devolvió un error al intentar acceder a la página. Por favor, inténtelo más tarde.',
            'type' => 'warning'
        ],
        'CONNECTION_ERROR' => [
            'message' => 'Error al conectar con el servidor. Verifique su conexión e inténtelo de nuevo.',
            'type' => 'warning'
        ],
        'CONTENT_ERROR' => [
            'message' => 'No se pudo obtener el contenido. En algunos casos, este articulo puede ser exclusivo para suscriptores.',
            'type' => 'warning'
        ],
        'INVALID_URL' => [
            'message' => 'Formato de URL inválido',
            'type' => 'error'
        ],
        'NOT_FOUND' => [
            'message' => 'Página no encontrada',
            'type' => 'error'
        ],
        'GENERIC_ERROR' => [
            'message' => 'Ocurrió un error al procesar su solicitud.',
            'type' => 'warning'
        ],
        'RESTRICTED_URL' => [
            'message' => 'Esta URL contiene contenido restringido y no se puede procesar por razones de seguridad.',
            'type' => 'error'
        ]
    ]
];
