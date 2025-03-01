<?php

namespace app\core;

use app\core\db\Database;
use app\models\User;

class Application
{
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public string $userClass;
    public static Application $app;
    public ?Controller $controller = null;
    public Router $router;
    public Request $request;
    public Response $response;
    public View $view;
    public ?UserModel $user;
    public Session $session;
    public Database $db;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public static function isAdmin()
    {
        $user = self::$app->user;
        if ($user) {
            return $user->role === User::ROLE_ADMIN;
        } else {
            return false;
        }
    }

    public static function catchPDOExc(\PDOException $e)
    {
        $app = self::$app;
        new Log($e->getMessage(), 'ERROR');
        $app->response->setStatusCode($e->getCode());
        echo $app->view->renderView('_pdoError', [
            'exception' => $e
        ]);
    }

    public static function displayFlashMessage($type = 'success')
    {
        $message = self::$app->session->getFlash($type);
        echo sprintf(
            '<div class="alert alert-%s">%s</div>',
            $type,
            $message
        );
    }
}
