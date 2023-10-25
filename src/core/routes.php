<?php

use Yosimar\Corona\Controller\LoginController;
use Yosimar\Corona\Controller\DashboardController;
use Yosimar\Corona\Controller\ReviewController;
use Yosimar\Corona\Controller\AdminController;
use \Bramus\Router\Router;

$router = new Router();

/***************************** ROUTES VIEW *****************************/

$router->get('/', function () {
    if (LoginController::authentication()) {
        header('Location: http://192.168.1.12/corona/dashboard');
        die();
    } else {
        require 'src/view/login/index.html';
    }
});

$router->post('/login', function () {
    if (LoginController::login()) {
        header('Location: http://192.168.1.12/corona/dashboard');
        die();
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->get('/logout', function () {
    LoginController::logout();
    header('Location: http://192.168.1.12/corona/');
    die();
});


$router->get('/dashboard', function () {
    if (LoginController::authentication()) {
        require 'src/view/dashboard/index.html';
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->get('/review', function () {
    if (LoginController::authentication()) {
        require 'src/view/review/index.html';
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->get('/admin', function () {
    if (LoginController::authentication()) {
        require 'src/view/admin/index.html';
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});



/***************************** ROUTES API *****************************/


/***************************** DASHBOARD *****************************/

$router->get('/api/dashboard/dataroutesreviewproduct', function () {
    if (LoginController::authentication()) {
        $data = DashboardController::findAllDashboardData();
        echo json_encode([
            'routes' => $data[0],
            'review' => $data[1],
            'products' => $data[2],
            'stores' => $data[3]
        ]);
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->post('/api/dashboard/save', function () {
    if (LoginController::authentication()) {
        if (DashboardController::saveReview()) {
            echo json_encode(["message" => "Revision guardada exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo guardar la revision"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

/***************************** REVIEWS *****************************/

$router->get('/api/review/datareviews', function () {
    if (LoginController::authentication()) {
        echo json_encode(ReviewController::findAllReviewData());
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/review/datareviewsbydate/{date}', function ($date) {
    if (LoginController::authentication()) {
        echo json_encode(ReviewController::findReviewsByDate($date));
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/review/pdfreview/{id}', function ($idReview) {
    if (LoginController::authentication()) {
        ReviewController::generatePdfReview($idReview);
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/review/pdfinvoice/{id}', function ($idReview) {
    if (LoginController::authentication()) {
        //ReviewController::generatePdfInvoice($idReview);
        if (ReviewController::sendPdfInvoice($idReview)) {
            echo json_encode(['message' => 'Correo enviado']);
        } else {
            echo json_encode(['error' => 'A ocurrido un error al enviar el correo']);
        }
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/review/sendmail/{id}', function ($idReview) {
    if (LoginController::authentication()) {
        if (ReviewController::sendPdfForMail($idReview)) {
            echo json_encode(['message' => 'Correo enviado']);
        } else {
            echo json_encode(['error' => 'A ocurrido un error al enviar el correo']);
        }
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

/***************************** ADMIN *****************************/

$router->get('/api/admin/dataroutes', function () {
    if (LoginController::authentication()) {
        echo json_encode(AdminController::findAllRoutesData());
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/admin/datausers', function () {
    if (LoginController::authentication()) {
        echo json_encode(AdminController::findAllUsersData());
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->get('/api/admin/datastores', function () {
    if (LoginController::authentication()) {
        echo json_encode(AdminController::findAllStoresData());
    } else {
        echo json_encode(["error" => "No se tiene los permisos necesarios para consultar este recurso"]);
    }
});

$router->post('/api/admin/saveroute', function () {
    if (LoginController::authentication()) {
        if (AdminController::saveRoute()) {
            echo json_encode(["message" => "Ruta guardada exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo guardar la Ruta"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->post('/api/admin/saveuser', function () {
    if (LoginController::authentication()) {
        if (AdminController::saveUser()) {
            echo json_encode(["message" => "Usuario guardado exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo guardar el Usuario"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->post('/api/admin/savestore', function () {
    if (LoginController::authentication()) {
        if (AdminController::saveStore()) {
            echo json_encode(["message" => "Tienda guardada exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo guardar la Tienda"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->delete('/api/admin/deleteroute', function () {
    if (LoginController::authentication()) {
        if (AdminController::deleteRoute()) {
            echo json_encode(["message" => "Ruta Eliminada exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo Eliminar la Ruta"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->delete('/api/admin/deleteuser', function () {
    if (LoginController::authentication()) {
        if (AdminController::deleteUser()) {
            echo json_encode(["message" => "Usuario Eliminado exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo Eliminar el Usuario"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

$router->delete('/api/admin/deletestore', function () {
    if (LoginController::authentication()) {
        if (AdminController::deleteStore()) {
            echo json_encode(["message" => "Tienda Eliminada exitosamente"]);
        } else {
            echo json_encode(["error" => "No se pudo Eliminar la Tienda"]);
        }
    } else {
        header('Location: http://192.168.1.12/corona/');
        die();
    }
});

/***************************** ERROR ******************************/

$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
    require 'src/view/error/index.html';
});

$router->run();
