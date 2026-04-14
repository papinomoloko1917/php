Stage #2

Route -> Dispatcher -> Controller -> ViewRenderer -> Response -> send()

# На втором шаге необходимо задуматься над реализацией:

# Шаг 1

Создать Response.

# Шаг 2

Создать ViewRenderer, который возвращает строку.

# Шаг 3

Реализовать поддержку layout.

# Шаг 4

Переделать Controller::view() так, чтобы он возвращал Response.

# Шаг 5

Переделать HomeController и AboutController на возврат Response.

# Шаг 6

Переделать Dispatcher, чтобы он ожидал Response.

# Шаг 7

Переделать ExceptionHandler, чтобы он возвращал Response.

# Шаг 8

Переделать App::run() на возврат Response.

# Шаг 9

В public/index.php вызывать send().

# Шаг 10

Обновить errorsPage.php, home.php, about.php под новый layout.
