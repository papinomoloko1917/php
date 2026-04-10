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
