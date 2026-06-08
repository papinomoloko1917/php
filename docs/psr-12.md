1. Установите расширение VS Code

Установите расширение PHP CS Fixer с идентификатором:

junstyle.php-cs-fixer

Оно поддерживает форматирование через Format Document, стандартную горячую клавишу форматтера и автоматический запуск при сохранении.

2. Установите PHP CS Fixer через Composer

В корне PHP-проекта выполните:

composer require --dev friendsofphp/php-cs-fixer

Разработчики PHP CS Fixer рекомендуют устанавливать его отдельно в каждый проект, а не глобально: так вся команда использует одну и ту же версию инструмента.

3. Добавьте настройки проекта

Создайте файл .vscode/settings.json в корне проекта:

{
  "[php]": {
    "editor.defaultFormatter": "junstyle.php-cs-fixer",
    "editor.formatOnSave": true,
    "editor.tabSize": 4,
    "editor.insertSpaces": true
  },

  "php-cs-fixer.executablePath": "${workspaceFolder}/vendor/bin/php-cs-fixer",
  "php-cs-fixer.executablePathWindows": "${workspaceFolder}\\vendor\\bin\\php-cs-fixer.bat",
  "php-cs-fixer.config": ".php-cs-fixer.dist.php",
  "php-cs-fixer.documentFormattingProvider": true
}

Ваш текущий пользовательский settings.json уже содержит эквивалентные строки, поэтому дублировать их необязательно. Однако хранить их в .vscode/settings.json удобно: настройка будет привязана к конкретному проекту и попадёт в репозиторий. Расширение поддерживает ${workspaceFolder}, отдельный путь для Windows и поиск конфигурационного файла в корне открытого workspace.

4. Зафиксируйте PSR-12 в конфиге проекта

Создайте файл .php-cs-fixer.dist.php в корне проекта:

<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'storage',
        'bootstrap/cache',
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);

Официальная документация рекомендует хранить проектную конфигурацию именно в .php-cs-fixer.dist.php. Набор @PSR12 включает правила форматирования, соответствующие стандарту PSR-12.

Это особенно важно для вашей конфигурации: расширение сначала ищет файлы из параметра "php-cs-fixer.config". Когда подходящий файл найден, оно запускает Fixer с аргументом --config. Значение "php-cs-fixer.rules": "@PSR12" используется только при отсутствии конфигурационного файла.

5. Проверьте работу

Запустите проверку вручную:

./vendor/bin/php-cs-fixer check --config=.php-cs-fixer.dist.php

Для автоматического исправления всего проекта:

./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php

После этого измените отступы или расположение фигурных скобок в любом обычном .php-файле и сохраните его. VS Code должен автоматически привести файл к PSR-12.

Добавлять "php-cs-fixer.onsave": true в вашем случае не требуется: у вас уже используется стандартный механизм VS Code "editor.formatOnSave": true. Расширение специально не запускает собственный обработчик сохранения повторно, когда стандартное форматирование при сохранении уже включено.

Для файлов *.blade.php продолжит использоваться отдельный Blade-форматтер, поскольку в ваших настройках они ассоциированы с языком blade, а PHP CS Fixer регистрируется для языка php.
