<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use App\Router\RouterInterface;
use Throwable;

class App {
    public function __construct(
        private readonly RouterInterface $router,
        private readonly DispatcherInterface $dispatcher,
    ) {
    }
    public function run(): void {
        try {
            $route = $this->router->resolve();
            $this->dispatcher->dispatch($route->handler());
        } catch (RouteNotFoundException $e) {
            http_response_code(404);
            echo '404 Not Found';
        } catch (MethodNotAllowedException $e) {
            http_response_code(405);
            echo '405 Method Not Allowed';
        } catch (Throwable $e) {
            http_response_code(500);
            echo '500 Internal Server Error';
        }
    }
}
