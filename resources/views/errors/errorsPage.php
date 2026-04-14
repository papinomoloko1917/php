<h1 class="mb-3"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

<?php if ($message !== null): ?>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <pre><?= htmlspecialchars('Файл: ' . $file . PHP_EOL . 'Строка: ' . $line, ENT_QUOTES, 'UTF-8') ?></pre>
<?php else: ?>
    <p>Произошла ошибка при обработке запроса.</p>
<?php endif; ?>
