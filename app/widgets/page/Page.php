<?php 

namespace app\widgets\page;


use dopler_core\App;
use dopler_core\Cache;
use RedBeanPHP\R;


class Page
{
    protected string $container = 'ul';
    protected array $language;
    protected string $class = 'page-menu';
    protected int $cache = 3600;
    protected string $cacheKey = 'dopler_page_menu';
    protected $menuTextHtml = '';
    protected string $prepend = '';
    protected $data;


    public function __construct($options = [])
    {
        $this->language = App::$app->getProperty('language');
        $this->getOptions($options);
        $this->run();
    }

    public function getOptions($options)
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)){
                $this->$k = $v;
            }
        }
    }

    public function run()
    {
        $cache = Cache::getInstance();
        $this->menuTextHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuTextHtml) {
            $this->data = R::getAssoc("SELECT p.*, pd.*
                                FROM page AS p
                                INNER JOIN page_description AS pd ON p.id = pd.page_id
                                WHERE pd.language_id = ?", [$this->language['id']]);
            $this->menuTextHtml = $this->getMenuPageHtml();
            if ($this->cache) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuTextHtml, $this->cache);
            }
        }
        $this->outPut();
    }

    public function getMenuPageHtml()
    {
        $html = '';
        foreach ($this->data as $k => $v) {
            $html .= "<li><a href='page/{$v['slug']}'>{$v['title']}</a></li>";
        }
        return $html;
    }

    public function outPut()
    {
        echo "<{$this->container} class='{$this->class}'>";
        echo $this->prepend;
        echo $this->menuTextHtml;
        echo "</{$this->container}>";
    }
}

?>