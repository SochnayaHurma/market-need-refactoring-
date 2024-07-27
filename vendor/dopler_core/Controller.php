<?php 

namespace dopler_core;


abstract class Controller
{
    public string|false $layout = '';
    public string|false $view = '';
    public $model;
    public array $data = array();
    public array $meta = [
        'title' => '',
        'description' => '',
        'keywords' => ''
    ];

    public function __construct(public array $route = array())
    {

    }
    public function get_model()
    {
        $model = 'app\models\\'
        . $this->route['admin_prefix'] 
        . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }
    public function getView()
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))
        ->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta(string $title = '', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => App::$app->getProperty('site_name') . '::' . $title,
            'description' => $description ? $description : '',
            'keywords' => $keywords ? $keywords : '',
        ];
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView($view, array $vars=[])
    {
        extract($vars);
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        require APP . "/views/{$prefix}/{$this->route['controller']}/{$view}.php";
        die;
    }

    public function error_404(string $folder = 'Error', string $view = '404', int $response = 404)
    {
        http_response_code($response);
        $this->setMeta(___('tpl_error_404'));
        $this->route['controller'] = 'Error';
        $this->view = $view;
    }
}   

?>