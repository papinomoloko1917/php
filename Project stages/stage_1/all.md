Я разрабатываю учебный проект для себя. Проект предназначен для изучения возможностей языка php. Изучи первый этап проекта, дай оценку и дай рекомендации к улучшению проекта. А также мне нужны шаги для реализации второго шага проекта.

Project stages/stage_1/stage_1.md
Stage #1
# На первом шаге проекта необходимо реализовать:
- Настроить автозагрузку файлов, можно с помощью composer (psr-4);
- Единую точку входа index.php;
- Подключение зависимостей и доп. пакетов таких как autoload.php и т.п. (подключаю файл bootstrap.php);
- Создать класс Request со статическим методом fromGlobals() для удобной работы с суперглобальными переменными $_SERVER;
- Создать класс App для запуска приложения с методом run(). Класс App должен поддерживать централизванную обработку ошибок (404, 405, 500), использую базовый php интерфейс - Throwable ;
- Создать файл web.php - для записи в него маршрутов типа - (url, метод, обработчик);
- Создать хелпер класс - Route для хранения маршрутов, который будет принимать uri, метод и обработчик маршрутов. Свойства данного класса должны быть приватными и доступными только для чтения;
- Создать класс Router который будет резолвить маршруты, также роутер должен различать 404 и 405 ошибки;
- Создать класс Dispatcher который будет принимать обработчик и реализовывать метод этого обработчика;
- Создать контроллеры с методами index() для отображения контента на странице;

***Примечание***
- Разработка проекта должна вестись исключительно с включенным строгим режимом - declare(strict type=1);
- На данном этапе нужно подготовить общий layout, но пока не реализовывать его;

Project stages/stage_1/architecture_stage_1.md
# На данном этаме архитектура приложения такая:
src
├── App.php
├── Controllers
│   ├── AboutController.php
│   └── HomeController.php
├── Dispatcher
│   ├── Dispatcher.php
│   └── DispatcherInterface.php
├── Exceptions
│   ├── MethodNotAllowedException.php
│   ├── RouteIncorrectException.php
│   └── RouteNotFoundException.php
├── Request
│   └── Request.php
├── Route
│   └── Route.php
└── Router
    ├── Router.php
    └── RouterInterface.php
public
└── index.php
routes
└── web.php
resources
├── layouts
│   └── app.layout.php
└── views
    ├── about.php
    └── home.php
bootstrap
└── bootstrap.php
nginx
└── default.conf

public/index.php
<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

use App\Request\Request;
use App\Router\Router;
use App\App;
use App\Dispatcher\Dispatcher;

// Собираем приложение
$request = Request::fromGlobals();
$routes = require dirname(__DIR__) . '/routes/web.php';
$router = new Router($routes, $request);
$dispatcher = new Dispatcher();
$app = new App($router, $dispatcher);

// Запускаем приложение
$app->run();

routes/web.php
<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Route\Route;

return [
    new Route('/', 'GET', [HomeController::class, 'index']),
    new Route('/about', 'GET', [AboutController::class, 'index']),
];

bootstrap/bootstrap.php
<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

src/Controllers/AboutController.php
<?php

declare(strict_types=1);

namespace App\Controllers;

class AboutController {
    public function index(): void {
        require dirname(__DIR__, 2) . '/resources/views/about.php';
    }
}

src/Controllers/HomeController.php
<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController {
    public function index(): void {
        require dirname(__DIR__, 2) . '/resources/views/home.php';
    }
}

src/Dispatcher/Dispatcher.php
<?php

declare(strict_types=1);

namespace App\Dispatcher;

use RuntimeException;

final class Dispatcher implements DispatcherInterface {
  public function __construct() {
  }
  public function dispatch(array $handler): mixed {
    if (count($handler) !== 2) {
      throw new RuntimeException('Неверный формат обработчика');
    }
    [$targetController, $method] = $handler;
    if (!is_string($targetController) || !is_string($method)) {
      throw new RuntimeException('Обработчик должен содержать имя класса и метода');
    }
    if (!class_exists($targetController)) {
      throw new RuntimeException("Класс {$targetController} не найден");
    }
    $controller = new $targetController();
    if (!method_exists($controller, $method)) {
      throw new RuntimeException("Метод {$method} не найден");
    }
    return $controller->$method();
  }
}

src/Dispatcher/DispatcherInterface.php
<?php

declare(strict_types=1);

namespace App\Dispatcher;

interface DispatcherInterface
{
  public function dispatch(array $handler): mixed;
}

src/Exceptions/MethodNotAllowedException.php
src/Exceptions/RouteIncorrectException.php
src/Exceptions/RouteNotFoundException.php
<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class MethodNotAllowedException extends RuntimeException {
}

<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class RouteIncorrectException extends RuntimeException {
}

<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class RouteNotFoundException extends RuntimeException {
}

src/Request/Request.php
<?php

declare(strict_types=1);

namespace App\Request;

class Request {
    public function __construct(
        private string $uri,
        private string $method,
        private string $path,
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

src/Route/Route.php
<?php

declare(strict_types=1);

namespace App\Route;

final class Route {
    public function __construct(
        private readonly string $path,
        private readonly string $method,
        private readonly array $handler,
    ) {
    }
    public function path(): string {
        return $this->path;
    }
    public function method(): string {
        return $this->method;
    }
    public function handler(): array {
        return $this->handler;
    }
}

src/Router/Router.php
<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\Request;
use App\Route\Route;
use App\Exceptions\RouteIncorrectException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;

class Router implements RouterInterface {
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

src/Router/RouterInterface.php
<?php

declare(strict_types=1);

namespace App\Router;

use App\Route\Route;

interface RouterInterface
{
  public function resolve(): Route;
}

src/App.php
<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\Router\RouterInterface;
use Throwable;

class App {
  public function __construct(
    private RouterInterface $router,
    private DispatcherInterface $dispatcher,
  ) {
  }
  public function run(): void {
    try {
      $route = $this->router->resolve();
      $this->dispatcher->dispatch($route->handler());
    } catch (Throwable $e) {
      http_response_code(500);
      echo $e->getMessage();
    }
  }
}

composer.json
{
    "name": "ninja/php",
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    },
    "authors": [
        {
            "name": "papinomoloko1917",
            "email": "varivodamax88@gmail.com"
        }
    ],
    "require-dev": {
        "symfony/var-dumper": "^7.4",
        "laravel/pint": "^1.29"
    }
}

README.md
Мой мини фреймворк на чистом php.

Данный фреймворк я создаю в учебных целях для изучения возможностей языка php.

Учебный проект разбит по логике на стадии, все стадии расположены в директории /Project stages.

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

resources/views/about.php
<h1 style="color: red;">
    About page
</h1>

resources/views/home.php
<h1 style="color: black;">
    Home page
</h1>

