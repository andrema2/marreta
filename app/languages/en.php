<?php

return [
    'walls_destroyed' => 'walls destroyed!',
    'url_placeholder' => 'Enter URL (e.g., https://example.com)',
    'analyze_button' => 'Analyze',
    'nav_integration' => 'Integrations',
    'nav_extension' => 'Install',
    'bookmarklet_title' => 'Add to Bookmarks',
    'bookmarklet_description' => 'Drag the button below to your bookmarks bar to quickly access on any page:',
    'open_in' => 'Open in {site_name}',
    'adblocker_warning' => 'Conflicts between {site_name} and ad blockers may cause a white screen. Use incognito mode or disable the extension.',
    'add_as_app' => 'Add as app',
    'add_as_app_step1' => 'In your browser, click the menu icon (three dots)',
    'add_as_app_step2' => 'Select "Install app" or "Add to home screen"',
    'add_as_app_step3' => 'Click "Install" for quick access',
    'add_as_app_step4' => 'Now you can directly share links to {site_name}',
    
    'messages' => [
        'BLOCKED_DOMAIN' => [
            'message' => 'This domain is blocked for extraction.',
            'type' => 'error'
        ],
        'DMCA_DOMAIN' => [
            'message' => 'The requested website cannot be displayed due to requests from its owners.',
            'type' => 'error'
        ],
        'DNS_FAILURE' => [
            'message' => 'Failed to resolve DNS for the domain. Please verify if the URL is correct.',
            'type' => 'warning'
        ],
        'HTTP_ERROR' => [
            'message' => 'The server returned an error while trying to access the page. Please try again later.',
            'type' => 'warning'
        ],
        'CONNECTION_ERROR' => [
            'message' => 'Error connecting to the server. Check your connection and try again.',
            'type' => 'warning'
        ],
        'CONTENT_ERROR' => [
            'message' => 'Could not fetch the content. In some cases, this article may be subscriber-only.',
            'type' => 'warning'
        ],
        'INVALID_URL' => [
            'message' => 'Invalid URL format',
            'type' => 'error'
        ],
        'NOT_FOUND' => [
            'message' => 'Page not found',
            'type' => 'error'
        ],
        'GENERIC_ERROR' => [
            'message' => 'An error occurred while processing your request.',
            'type' => 'warning'
        ],
        'RESTRICTED_URL' => [
            'message' => 'This URL contains restricted content and cannot be processed for security reasons.',
            'type' => 'error'
        ]
    ]
];
