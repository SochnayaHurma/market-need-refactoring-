<?php 

namespace dopler_core;

class Pagination
{
    public $total;
    public $currentPage;
    public $perPage;
    public $countPages;
    public $uri;

    public function __construct($page, $perPage, $total)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->uri = $this->getParams();
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
    }

    public function getHtml()
    {
        $back = null;
        $forward = null;
        $startpage = null;
        $endpage = null;
        $page2Left = null;
        $page1Left = null;
        $page2Right = null;
        $page1Right = null;

        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='". $this->getLink($this->currentPage - 1) ."'>&lt;</a></li>";
        }
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='". $this->getLink($this->currentPage + 1) ."'>&gt;</a></li>";
        }
        if ($this->currentPage > 3) {
            $startpage = "<li class='page-item'><a class='page-link' href='" . $this->getLink(1) ."'>&laquo;</a></li>";
        }
        if ($this->currentPage < ($this->countPages - 2)) {
            $endpage = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->countPages) . "'>&raquo;</a></li>";
        }
        if ($this->currentPage - 2 > 0) {
            $page2Left = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage - 2) . "'>" . $this->currentPage - 2 . "</a></li>";
        }
        if ($this->currentPage - 1 > 0) {
            $page1Left = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage - 1) ."'>" . $this->currentPage - 1 . "</a></li>";
        }
        if ($this->currentPage + 1 <= $this->countPages) {
            $page1Right = "<li class='page-item'><a class='page-link' href='" . $this->getLink($this->currentPage + 1) . "'>". $this->currentPage + 1 ."</a></li>";
        }
        if ($this->currentPage + 2 <= $this->countPages) {
            $page2Right = "<li class='page-item'><a class='page-link' href='". $this->getLink($this->currentPage + 2)."'>". $this->currentPage + 2 ."</a></li>";
        }
        return "<nav aria-label='Page navigation example'><ul class='pagination'>" 
                . $startpage . $back . $page2Left . $page1Left 
                . "<li class='page-item active'><a class='page-link' href='". $this->getLink($this->currentPage) ."'>". $this->currentPage ."</a></li>"
                . $page1Right . $page2Right . $forward . $endpage . "</ul></nav>";
    }
    public function getLink($page)
    {
        if ($page == 1) {
            return trim($this->uri, '?&');
        }
        if (str_contains($this->uri, '&')) {
            return "{$this->uri}page={$page}";
        } else {
            if (str_contains($this->uri, '?')){
                return "{$this->uri}page={$page}";
            } else {
                return "{$this->uri}?page={$page}";
            }
        }
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    public function getCountPages()
    {
        return ceil($this->total / $this->perPage) ?: 1;
    }

    public function getCurrentPage($page)
    {

        if (!$page || $page < 1) $page = 1;
        if ($page > $this->countPages) $page = $this->countPages;
        return $page;
    }

    public function getStart()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]) && $url[1] != '') {
            $uri .= '?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&";
            }
        }
        return $uri;
    }
}
?>