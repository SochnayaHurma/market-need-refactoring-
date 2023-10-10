<?php 

namespace app\models;

use RedBeanPHP\R;

class Page extends AppModel
{
    public function get_page(string $slug, array $lang): array
    {
        return R::getRow("SELECT p.*, pd.* 
                          FROM page AS p 
                          JOIN page_description AS pd ON p.id = pd.page_id
                          WHERE p.slug = ? AND pd.language_id = ?", [$slug, $lang['id']]);
    }
}

?>