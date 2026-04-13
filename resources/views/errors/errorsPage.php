<h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

<?php
if (isset($message)) {
    $file = 'Файл: ' . $file;
    $line = 'Строка №' . $line;

    echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    echo '<pre>';
    echo htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
    echo '<pre>';
    echo htmlspecialchars($line, ENT_QUOTES, 'UTF-8');
}
?>
