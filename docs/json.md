{
  "security.allowedUNCHosts": ["wsl.localhost", "Server-NAS"],
  "security.workspace.trust.untrustedFiles": "open",
  "workbench.startupEditor": "none",
  "workbench.iconTheme": "vscode-icons",
  "workbench.settings.useSplitJSON": true,
  "workbench.editor.labelFormat": "medium",
  "chat.viewSessions.orientation": "stacked",
  "breadcrumbs.enabled": true,

  "explorer.confirmDelete": false,
  "explorer.confirmDragAndDrop": false,
  "explorer.compactFolders": false,
  "files.autoSave": "onFocusChange",
  "files.eol": "\n",
  "files.trimTrailingWhitespace": true,
  "files.insertFinalNewline": true,
  "files.associations": {
    "*.css": "css",
    "*.scss": "scss",
    "*.sass": "sass",
    "*.less": "less",
    "*.blade.php": "blade"
  },
  "files.exclude": {
    "**/.git": true,
    "**/.DS_Store": true,
    "**/node_modules": true,
    "**/storage/logs": true,
    "**/storage/framework/cache": true,
    "**/storage/framework/sessions": true,
    "**/storage/framework/views": true,
    "**/bootstrap/cache": true,
    "**/.phpunit.result.cache": true
  },
  "files.watcherExclude": {
    "**/.git/objects/**": true,
    "**/.git/subtree-cache/**": true,
    "**/node_modules/**": true,
    "**/vendor/**": true,
    "**/storage/framework/**": true,
    "**/storage/logs/**": true,
    "**/bootstrap/cache/**": true
  },
  "search.exclude": {
    "**/.git": true,
    "**/node_modules": true,
    "**/vendor": true,
    "**/storage/logs": true,
    "**/storage/framework": true,
    "**/bootstrap/cache": true
  },

  // Настройки PHP CS Fixer — ЕДИНСТВЕННЫЕ для PHP
  "php-cs-fixer.executablePath": "/home/ninja/.config/composer/vendor/bin/php-cs-fixer",
  "php-cs-fixer.onsave": true,
  "php-cs-fixer.rules": "@PSR12",
  "php-cs-fixer.documentFormattingProvider": true,

  "[php]": {
    "editor.defaultFormatter": "junstyle.php-cs-fixer",
    "editor.formatOnSave": true, // оставляем глобальное форматирование
    "editor.tabSize": 4,
    "editor.insertSpaces": true,
    "editor.rulers": [120]
  },

  // Отключаем форматирование в Intelephense
  "intelephense.format.enable": false,

  // Остальные настройки (без изменений)
  "editor.fontFamily": "JetBrains Mono Nerd Font, Fira Code, monospace",
  "editor.fontLigatures": true,
  "editor.fontSize": 14,
  "editor.lineHeight": 24,
  "editor.tabSize": 4,
  "editor.detectIndentation": false,
  "editor.formatOnSave": true,
  "editor.formatOnPaste": false,
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": "explicit",
    "source.fixAll.stylelint": "explicit",
    "source.organizeImports": "explicit"
  },
}
