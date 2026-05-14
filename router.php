<?php
require_once __DIR__ . '/app/controllers/home.controller.php';
require_once __DIR__ . '/app/controllers/genres.controller.php';
require_once __DIR__ . '/app/controllers/books.controller.php';
require_once __DIR__ . '/app/controllers/auth.controller.php';

require_once __DIR__ . '/app/middlewares/session.middleware.php';
require_once __DIR__ . '/app/middlewares/guard.middleware.php';

session_start();

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

/**  TABLA DE RUTEO
 * Público
 * /home                      ---> HomeController::showHome()
 * /libros                    ---> BooksController::showBooks()
 * /libros/ver/:id            ---> BooksController::showBook(:id)
 * /generos                   ---> GenreController->showGenres()
 * /generos/:id               ---> GenreController->showGenre(:id)
 *
 * Auth
 * /login                     ---> AuthController::showLogin()
 * /login/auth                ---> AuthController::authenticate()  [POST]
 * /logout                    ---> AuthController::logout()
 *
 * Admin (requiere login - GuardMiddleware)
 * /admin/libros              ---> BooksController::showAdmin()
 * /admin/libros/agregar      ---> BooksController::showAddForm() [GET] / addBook() [POST]
 * /admin/libros/editar/:id   ---> BooksController::showEditForm(:id) [GET] / editBook(:id) [POST]
 * /admin/libros/eliminar/:id ---> BooksController::deleteBook(:id)
 *
 * /admin/generos              ---> GenreController::showAdmin()
 * /admin/generos/agregar      ---> GenreController::showAddForm() [GET] / addGenre() [POST]
 * /admin/generos/editar/:id   ---> GenreController::showEditForm(:id) [GET] / editGenre(:id) [POST]
 * /admin/generos/eliminar/:id ---> GenreController::deleteGenre(:id)
 */

$action = !empty($_GET['action']) ? $_GET['action'] : 'home';
$params = explode('/', $action);

// Determina si la petición es POST (para diferenciar mostrar formulario vs procesar datos)
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$req = new StdClass();
$req = (new SessionMiddleware())->run($req);

switch ($params[0]) {
    case 'home':
        (new HomeController())->showHome();
        break;

    case 'generos':
        $controller = new GenreController();
        if (isset($params[1])) {
            $controller->showGenre($params[1]);
        } else {
            $controller->showGenres();
        }
        break;

    case 'libros':
        $controller = new BooksController();
        if (isset($params[1]) && $params[1] === 'ver' && isset($params[2])) {
            $controller->showBook($params[2]);
        } else {
            $controller->showBooks();
        }
        break;

    case 'login':
        $controller = new AuthController();
        if (isset($params[1]) && $params[1] === 'auth') {
            $controller->authenticate();
        } else {
            $controller->showLogin();
        }
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'admin':
        $req = (new GuardMiddleware())->run($req);

        switch ($params[1] ?? '') {
            //------------------ADMIN LIBROS------------------
            case 'libros':
                $controller = new BooksController();
                $subAction = $params[2] ?? '';

                switch ($subAction) {
                    case '':
                        $controller->showAdmin();
                        break;

                    case 'agregar':
                        if ($isPost) {
                            $controller->addBook();
                        } else {
                            $controller->showAddForm();
                        }
                        break;

                    case 'editar':
                        if (isset($params[3])) {
                            $id = $params[3];
                            if ($isPost) {
                                $controller->editBook($id);
                            } else {
                                $controller->showEditForm($id);
                            }
                        } else {
                            notFound();
                        }
                        break;

                    case 'eliminar':
                        if (isset($params[3])) {
                            $controller->deleteBook($params[3]);
                        } else {
                            notFound();
                        }
                        break;

                    default:
                        notFound();
                        break;
                }
                break;

            //------------------ADMIN GENEROS------------------
            case 'generos':
                $controller = new GenreController();
                $subAction = $params[2] ?? '';

                switch ($subAction) {
                    case '':
                        $controller->showAdmin();
                        break;

                    case 'agregar':
                        if ($isPost) {
                            $controller->addGenre();
                        } else {
                            $controller->showAddForm();
                        }
                        break;

                    case 'editar':
                        if (isset($params[3])) {
                            $id = $params[3];
                            if ($isPost) {
                                $controller->editGenre($id);
                            } else {
                                $controller->showEditForm($id);
                            }
                        } else {
                            notFound();
                        }
                        break;

                    case 'eliminar':
                        if (isset($params[3])) {
                            $controller->deleteGenre($params[3]);
                        } else {
                            notFound();
                        }
                        break;

                    default:
                        notFound();
                        break;
                }
                break;

            default:
                notFound();
                break;
        }
        break;

    default:
        notFound();
        break;
}


function notFound() {
    http_response_code(404);
    echo '404 - Página no encontrada';
}
