<?php
/* Please observe the publisher's rights
* website : munix.ir
 * forum : forum.munix.ir
 * Iran
 *  Edit Date : 2018-06-15
 * Monix native script open source
*/
define('THEME_STATE', 'installing');
define('APP_NAME', 'Monix');
define('VER_NO', '2.0');
define('ROOT_DIR', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);
define('ClASS_DIR', APP_DIR . 'class' . DIRECTORY_SEPARATOR);
define('CONNECT_DIR', ROOT_DIR . 'Connect' . DIRECTORY_SEPARATOR);
define('LANG_DIR', CONNECT_DIR . 'lang' . DIRECTORY_SEPARATOR);
define('SYSTEM_DIR', ROOT_DIR . 'System' . DIRECTORY_SEPARATOR);
define('PLUGIN_DIR', CONNECT_DIR . 'Plugin/');
define('THEME_DIR', 'Connect/theme' . DIRECTORY_SEPARATOR);
define('UPLOAD_DIR', ROOT_DIR . 'Connect/upload' . DIRECTORY_SEPARATOR);
define('UPLOAD_PATH', 'Connect/upload' . DIRECTORY_SEPARATOR);
define('ClASSES_DIR', APP_DIR . 'classes' . DIRECTORY_SEPARATOR);
define('ADMIN_CONTLORER_DIR', ROOT_DIR . 'tk-panel/controler' . DIRECTORY_SEPARATOR);
define('ADMIN_THEME_DIR', ROOT_DIR . 'tk-panel/theme' . DIRECTORY_SEPARATOR);
define('ADMIN_DIR', ROOT_DIR . 'tk-panel/');
require_once(APP_DIR . 'config.php');
require_once(ClASS_DIR . 'Db.class.php');
$db = new Db();
require_once(ClASS_DIR . 'pagingMonix.class.php');
require_once(ClASS_DIR . 'security.csrf.php');
require_once(ClASS_DIR . 'class.upload.php');
require_once(ClASS_DIR . 'validate.class.php');
require_once(ClASS_DIR . 'paging.class.php');
$security = new \security\CSRF;
$token = $security->set(3, 3600);
$vt = new GUMP();
require_once 'app/vendor/autoload.php';
$router = new Phroute\Phroute\RouteCollector;
require_once(SYSTEM_DIR . 'php-hooks.php');
require_once(APP_DIR . 'function.php');
require_once(ClASSES_DIR . 'api.class.php');
require ClASSES_DIR . 'admin.class.php';
require_once(ROOT_DIR . 'router.php');
require_once(APP_DIR . 'app.php');
require THEME_DEFAULT . "/index.php";
require_once(ClASS_DIR . 'lang.class.php');
require ClASS_DIR . 'smarty/SmartyBC.class.php';
$router->get('/logout', function () {
    if (isset($_SESSION['user_login'])) {
        session_destroy();
        session_unset();
        Redirect('/');
    } else {
        Redirect('/');
    }
});
$router->get('/lang', function () {
    require_once(ClASS_DIR . 'lang.class.php');
});
if (!isset($_GET['ajax']) and !isset($_GET['AjaxLoadPlugin']) and !isset($_GET['js'])) {
    if (isset($_SESSION['user_login'])) {
        $router->any('/', function () {
            return view(VIEW);
        });
    } else {
        if (!isset($_GET['Guest'])) {
            $router->get('/', function () {
                return view('login');
            });
        } elseif (isset($_GET['Guest']) and !isset($_GET['track'])) {
            if (se('send_tiket_goust') == "1") {
                return view('Guest');
            } else {
                header('location: /');
            }
        } elseif (isset($_GET['track'])) {
            if (se('send_tiket_goust') == "1") {
                return view('track_guest');
            } else {
                header('location: /');
            }
        }
    }


# NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
    $dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Print out the value returned from the dispatched function
    echo $response;
}