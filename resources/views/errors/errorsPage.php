<h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <pre><?= htmlspecialchars('Файл: ' . $file . PHP_EOL . 'Строка: ' . $line, ENT_QUOTES, 'UTF-8') ?></pre>
<?php endif; ?>
