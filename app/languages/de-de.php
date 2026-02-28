<?php

return [
    'walls_destroyed' => 'Paywall überwunden',
    'url_placeholder' => 'Adresse eingegeben (z.B., https://example.com)',
    'analyze_button' => 'Analysiere',
    'nav_integration' => 'Integrations',
    'nav_extension' => 'Install',
    'bookmarklet_title' => 'Zu Lesezeichen hinzufügen',
    'bookmarklet_description' => 'Ziehe Sie die Schaltfläche unten in Ihre Lesezeichenleiste, um schnell auf zuzugreifen:',
    'open_in' => 'Öffne {site_name}',
    'adblocker_warning' => 'Bei Konflikten zwischen {site_name} und Werbeblockern kann ein weißer Bildschirm angezeigt werden. Verwenden Sie den Inkognito-Modus oder deaktivieren Sie die Erweiterung.',
    'add_as_app' => 'Als app hinzufügen',
    'add_as_app_step1' => 'Klicken Sie in Ihrem Browser auf das Menüsymbol (drei Punkte)',
    'add_as_app_step2' => 'Wählen Sie "App installieren" oder "Zum Startbildschirm hinzufügen"',
    'add_as_app_step3' => 'Klicken Sie für den Schnellzugriff auf „Installieren"',
    'add_as_app_step4' => 'Jetzt können Sie Links direkt zu {site_name} teilen',
    
    'messages' => [
        'BLOCKED_DOMAIN' => [
            'message' => 'Diese Seite ist nicht erlaubt.',
            'type' => 'error'
        ],
        'DMCA_DOMAIN' => [
            'message' => 'Die angeforderte Website kann aufgrund von Anfragen ihrer Eigentümer nicht angezeigt werden.',
            'type' => 'error'
        ],
        'DNS_FAILURE' => [
            'message' => 'DNS für die Domain konnte nicht aufgelöst werden. Bitte überprüfe, ob die URL korrekt ist.',
            'type' => 'warning'
        ],
        'HTTP_ERROR' => [
            'message' => 'Der Server hat beim Zugriff auf die Seite einen Fehler gemeldet. Bitte versuchen Sie es später noch einmal.',
            'type' => 'warning'
        ],
        'CONNECTION_ERROR' => [
            'message' => 'Fehler beim Verbinden mit dem Server. Überprüfen Sie Ihre Verbindung und versuchen Sie es erneut.',
            'type' => 'warning'
        ],
        'CONTENT_ERROR' => [
            'message' => 'Der Inhalt konnte nicht abgerufen werden. In einigen Fallen kann der Artikel nur fur Abonnenten verfugbar sein.',
            'type' => 'warning'
        ],
        'INVALID_URL' => [
            'message' => 'Ungültiges URL-Format',
            'type' => 'error'
        ],
        'NOT_FOUND' => [
            'message' => 'Seite nicht gefunden',
            'type' => 'error'
        ],
        'GENERIC_ERROR' => [
            'message' => 'Bei der Bearbeitung Ihrer Anfrage ist ein Fehler aufgetreten.',
            'type' => 'warning'
        ],
        'RESTRICTED_URL' => [
            'message' => 'Diese URL enthält eingeschränkten Inhalt und kann aus Sicherheitsgründen nicht verarbeitet werden.',
            'type' => 'error'
        ]
    ]
];
