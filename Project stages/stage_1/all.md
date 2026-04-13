Я разрабатываю учебный проект для себя. Проект предназначен для изучения возможностей языка php. Изучи первый этап проекта, дай оценку и дай рекомендации к улучшению проекта. А также мне нужны шаги для реализации второго шага проекта.

# На данном этаме архитектура приложения такая:

.
├── Project stages
│ ├── stage_1
│ │ ├── all.md
│ │ ├── architecture_stage_1.md
│ │ └── stage_1.md
│ └── stage_2
│ └── stage_2.md
├── README.md
├── bootstrap
│ └── bootstrap.php
├── composer.json
├── composer.lock
├── docker-compose.yml
├── nginx
│ └── default.conf
├── php
│ └── Dockerfile
├── public
│ └── index.php
├── resources
│ ├── layouts
│ │ └── app.layout.php
│ └── views
│ ├── about.php
│ ├── errors
│ │ └── errorsPage.php
│ └── home.php
├── routes
│ └── web.php
└── src
├── App.php
├── Controllers
│ ├── AboutController.php
│ ├── Controller.php
│ └── HomeController.php
├── Dispatcher
│ ├── Dispatcher.php
│ └── DispatcherInterface.php
├── ErrorHandler
│ └── ExceptionHandler.php
├── Exceptions
│ ├── MethodNotAllowedException.php
│ ├── RouteIncorrectException.php
│ └── RouteNotFoundException.php
├── Request
│ └── Request.php
└── Routing
├── Route.php
├── Router.php
└── RouterInterface.php

Stage #1

# На первом шаге проекта необходимо реализовать:

- Настроить автозагрузку файлов, можно с помощью composer (psr-4);
- Единую точку входа index.php;
- Подключение зависимостей и доп. пакетов таких как autoload.php и т.п. (подключаю файл bootstrap.php);
- Создать класс Request со статическим методом fromGlobals() для удобной работы с суперглобальными переменными $\_SERVER;
- Создать класс App для запуска приложения с методом run(). Класс App должен поддерживать централизванную обработку ошибок (404, 405, 500), использую базовый php интерфейс - Throwable ;
- Создать файл web.php - для записи в него маршрутов типа - (url, метод, обработчик);
- Создать хелпер класс - Route для хранения маршрутов, который будет принимать uri, метод и обработчик маршрутов. Свойства данного класса должны быть приватными и доступными только для чтения;
- Создать класс Router который будет резолвить маршруты, также роутер должен различать 404 и 405 ошибки;
- Создать класс Dispatcher который будет принимать обработчик и реализовывать метод этого обработчика;
- Создать контроллеры с методами index() для отображения контента на странице;
- Создать класс ExceptionHandler для централизованной обработки ошибок в App;
- Ввести константу окружения (debug-флаг) APP_DEBUG, с помошью которой можно включать/отключать dev-режим, данную константу можно расположить в bootstrap.php;

**_Примечание_**

- Разработка проекта должна вестись исключительно с включенным строгим режимом - declare(strict type=1);
- На данном этапе нужно подготовить общий layout, но пока не реализовывать его;
- В рамках первого этапа реализовывать класс Response не нужно.

bootstrap/bootstrap.php

<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

const APP_DEBUG = true; //debug-флаг

public/index.php
<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

error_reporting(APP_DEBUG ? E_ALL : 0);
ini_set('display_errors', APP_DEBUG ? '1' : '0');

use App\Request\Request;
use App\ErrorHandler\ExceptionHandler;
use App\Routing\Router;
use App\Dispatcher\Dispatcher;
use App\App;

// Собираем приложение
$request = Request::fromGlobals();
$routes = require dirname(__DIR__) . '/routes/web.php';
$router = new Router($routes, $request);
$dispatcher = new Dispatcher();
$exceptionHandler = new ExceptionHandler(APP_DEBUG);

$app = new App($router, $dispatcher, $exceptionHandler); // Инициализируем приложение

$app->run(); // Запускаем приложение

src/App.php
<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\ErrorHandler\ExceptionHandler;
use App\Routing\RouterInterface;
use Throwable;

class App {
    public function __construct(
        private readonly RouterInterface $router,
        private readonly DispatcherInterface $dispatcher,
        private readonly ExceptionHandler $exceptionHandler,
    ) {
    }
    public function run(): void {
        try {
            $route = $this->router->resolve();
            $this->dispatcher->dispatch($route->handler());
        } catch (Throwable $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}

src/Routing/Route.php
<?php

declare(strict_types=1);

namespace App\Routing;

use App\Exceptions\RouteIncorrectException;
use Closure;

final class Route {
    private readonly string $path;
    private readonly string $method;
    private readonly array|Closure $handler;

    /** @param array {0: class-string, 1: string}|Closure $handler */
    public function __construct(string $path, string $method, array|Closure $handler) {
        $this->path = $path;
        $this->method = strtoupper($method);
        $this->handler = $handler;

        if ($path === '') {
            throw new RouteIncorrectException('Путь маршрута не может быть пустым');
        }
        if (!$this->validateHandler($this->handler)) {
            throw new RouteIncorrectException('Некорректный обработчик маршрута');
        }
    }
    /** @param array {0: class-string, 1: string} $handler */
    public static function get(string $path, array|Closure $handler): self {
        return new self($path, 'GET', $handler);
    }
    /** @param array {0: class-string, 1: string}|Closure $handler */
    public static function post(string $path, array|Closure $handler): self {
        return new self($path, 'POST', $handler);
    }
    public function path(): string {
        return $this->path;
    }
    public function method(): string {
        return $this->method;
    }
    /** @return array {0: class-string, 1: string}|Closure */
    public function handler(): array|Closure {
        return $this->handler;
    }
    /** * @param array{0:class-string, 1:string}|Closure $handler */
    private function validateHandler(array|Closure $handler): bool {
        if ($handler instanceof Closure) {
            return true;
        }
        return isset($handler[0], $handler[1])
            && is_string($handler[0])
            && is_string($handler[1]);
    }
}

src/Routing/Router.php
<?php

declare(strict_types=1);

namespace App\Routing;

use App\Request\Request;
use App\Routing\Route;
use App\Exceptions\RouteIncorrectException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;

class Router implements RouterInterface {
    /** @param list<Route> $routes */
    public function __construct(
        private array $routes,
        private Request $request,
    ) {
    }
    public function resolve(): Route {
        $pathMatched = false;
        foreach ($this->routes as $route) {
            if (!$route instanceof Route) {
                throw new RouteIncorrectException('Некорректный маршрут');
            }
            if ($route->path() === $this->request->path()) {
                $pathMatched = true;
                if ($route->method() === $this->request->method()) {
                    return $route;
                }
            }
        }
        if ($pathMatched) {
            throw new MethodNotAllowedException('Метод не разрешен');
        }
        throw new RouteNotFoundException('Маршрут не найден');
    }
}
src/Routing/RouterInterface.php
<?php

declare(strict_types=1);

namespace App\Routing;

use App\Routing\Route;

interface RouterInterface {
    public function resolve(): Route;
}
src/Request/Request.php
<?php

declare(strict_types=1);

namespace App\Request;

class Request {
    public function __construct(
        private readonly string $uri,
        private readonly string $method,
        private readonly string $path,
    ) {
    }
    public static function fromGlobals(): self {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $path = parse_url($uri, PHP_URL_PATH);
        $path = is_string($path) ? rtrim($path, '/') : '';
        $path = $path ?: '/';

        return new self(
            uri: $uri,
            method: $method,
            path: $path,
        );
    }
    public function uri(): string {
        return $this->uri;
    }
    public function method(): string {
        return $this->method;
    }
    public function path(): string {
        return $this->path;
    }
}
src/Exceptions/MethodNotAllowedException.php
<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class MethodNotAllowedException extends RuntimeException {
}

src/Exceptions/RouteIncorrectException.php
<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class RouteIncorrectException extends RuntimeException {
}

src/Exceptions/RouteNotFoundException.php
<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class RouteNotFoundException extends RuntimeException {
}
src/ErrorHandler/ExceptionHandler.php
<?php

declare(strict_types=1);

namespace App\ErrorHandler;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use Throwable;

final class ExceptionHandler {
    public function __construct(
        private readonly bool $debug = false,
    ) {
    }
    public function handle(Throwable $e): void {
        [$statusCode, $title] = $this->resolveError($e);

        http_response_code($statusCode);

        $message = $this->debug ? $e->getMessage() : null;

        $file = $this->debug ? $e->getFile() : null;

        $line = $this->debug ? $e->getLine() : null;

        $exception = $this->debug ? $e : null;

        $this->render($title, [
            'message' => $message,
            'exception' => $exception,
            'file' => $file,
            'line' => $line,
        ]);
    }
    private function resolveError(Throwable $e): array {
        return match (true) {
            $e instanceof RouteNotFoundException => [404, '404 | Not Found'],
            $e instanceof MethodNotAllowedException => [405, '405 | Method Not Allowed'],
            default => [500, '500 | Internal Server Error'],
        };
    }
    /** *@param array <string, mixed> $data */
    private function render(string $title, array $data = []): void {
        $viewPath = dirname(__DIR__, 2) . '/resources/views/errors/errorsPage.php';

        if (!file_exists($viewPath)) {
            echo 'View not found';
            return;
        }

        extract($data, EXTR_SKIP);

        require $viewPath;
    }
}
src/Dispatcher/Dispatcher.php
<?php

declare(strict_types=1);

namespace App\Dispatcher;

use RuntimeException;
use Closure;

final class Dispatcher implements DispatcherInterface {
    public function __construct() {
    }
    /** @param array {0: class-string, 1: string} $handler */
    public function dispatch(array|Closure $handler): mixed {
        if ($handler instanceof Closure) {
            return $handler();
        }
        [$controllerClass, $method] = $handler;
        if (!class_exists($controllerClass)) {
            throw new RuntimeException("Класс {$controllerClass} не найден");
        }
        $controller = new $controllerClass();
        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Метод {$method} не найден");
        }
        return $controller->{$method}();
    }
}

src/Dispatcher/DispatcherInterface.php
<?php

declare(strict_types=1);

namespace App\Dispatcher;

use Closure;

interface DispatcherInterface {
    public function dispatch(array|Closure $handler): mixed;
}
src/Controllers/AboutController.php
<?php

declare(strict_types=1);

namespace App\Controllers;

class AboutController extends Controller {
    public function index(): void {
        $this->view('about');
    }
}

src/Controllers/Controller.php
<?php

declare(strict_types=1);

namespace App\Controllers;

use RuntimeException;

abstract class Controller {
    protected function view(string $template, array $data = []): void {
        $viewPath = dirname(__DIR__, 2) . "/resources/views/{$template}.php";
        if (!file_exists($viewPath)) {
            throw new RuntimeException('Файла не существует');
        }
        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}


src/Controllers/HomeController.php
<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends Controller {
    public function index(): void {
        $this->view('home');
    }
}
routes/web.php
<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/about', [AboutController::class, 'index']),
    Route::get('/test', function () {
        echo '12345';
    }),
];
resources/layouts/app.layout.php
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="container">

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
resources/views/errors/errorsPage.php
<h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

<?php if (isset($message)): ?>

    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <pre><?= htmlspecialchars('Файл: ' . $file . PHP_EOL . 'Строка: ' . $line, ENT_QUOTES, 'UTF-8') ?></pre>

<?php endif; ?>

resources/views/about.php

<h1 style="color: red;">
    About page
</h1>
resources/views/home.php
<h1 style="color: black;">
    Home page
</h1>
nginx/default.conf
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

}
