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
