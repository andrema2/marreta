<?php

return [
    'walls_destroyed' => 'paredes derrubadas!',
    'url_placeholder' => 'Digite a URL (ex: https://exemplo.com)',
    'analyze_button' => 'Analisar',
    'nav_integration' => 'Integrações',
    'nav_extension' => 'Instale',
    'bookmarklet_title' => 'Adicione aos Favoritos',
    'bookmarklet_description' => 'Adicione aos favoritos arrastando o botão abaixo <strong>para sua barra de favoritos</strong>!',
    'open_in' => 'Me arrasta',
    'adblocker_warning' => 'Conflitos entre o {site_name} e bloqueadores de anúncios podem causar tela branca. Use o modo anônimo ou desative a extensão.',
    'add_as_app' => 'Adicionar como aplicativo',
    'add_as_app_step1' => 'No seu navegador, clique no ícone de menu (três pontos)',
    'add_as_app_step2' => 'Selecione "Instalar aplicativo" ou "Adicionar à tela inicial"',
    'add_as_app_step3' => 'Clique em "Instalar"',
    'add_as_app_step4' => 'Agora pode compartilhar diretamente links para o {site_name}',
    
    'messages' => [
        'BLOCKED_DOMAIN' => [
            'message' => 'Este domínio está bloqueado para extração.',
            'type' => 'error'
        ],
        'DMCA_DOMAIN' => [
            'message' => 'O site solicitado não pode ser exibido por exigência dos seus proprietários.',
            'type' => 'error'
        ],
        'DNS_FAILURE' => [
            'message' => 'Falha ao resolver DNS para o domínio. Verifique se a URL está correta.',
            'type' => 'warning'
        ],
        'HTTP_ERROR' => [
            'message' => 'O servidor retornou um erro ao tentar acessar a página. Tente novamente mais tarde.',
            'type' => 'warning'
        ],
        'CONNECTION_ERROR' => [
            'message' => 'Erro ao conectar com o servidor. Verifique sua conexão e tente novamente.',
            'type' => 'warning'
        ],
        'CONTENT_ERROR' => [
            'message' => 'Nao foi possivel obter o conteudo. Em alguns casos, o artigo pode ser exclusivo para assinantes.',
            'type' => 'warning'
        ],
        'INVALID_URL' => [
            'message' => 'Formato de URL inválido',
            'type' => 'error'
        ],
        'NOT_FOUND' => [
            'message' => 'Página não encontrada',
            'type' => 'error'
        ],
        'GENERIC_ERROR' => [
            'message' => 'Ocorreu um erro ao processar sua solicitação.',
            'type' => 'warning'
        ],
        'RESTRICTED_URL' => [
            'message' => 'Esta URL contém conteúdo restrito e não pode ser processada por motivos de segurança.',
            'type' => 'error'
        ]
    ]
];
