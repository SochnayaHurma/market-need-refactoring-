<?php 

namespace dopler_core;


use Valitron\Validator;
use RedBeanPHP\R;

abstract class Model
{
    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];
    public array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }

    public function load(bool $post = true)
    {
        $data = $post ? $_POST : $_GET;
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate(array|string $data): bool
    {
        Validator::langDir(APP . '/languages/validator/lang');
        if ($lang = App::$app->getProperty('language')) {
            Validator::lang($lang['code']);
        }
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels()); 
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
        // $validator->labels();
    }

    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $field) {
                $errors .= '<li>' . $field . '</li>';
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->labels as $key => $value) {
            $labels[$key] = ___($value);
        }
        return $labels;
    }

    public function save(string $table): int|string
    {
        $tbl = R::dispense($table);

        foreach ($this->attributes as $key => $value ){
            if ($value != '') {
                $tbl->$key = $value;
            }
        }
        return R::store($tbl);
    }

    public function update(string $table, int $id): int|string
    {
        $tbl = R::load($table, $id);
        foreach ($this->attributes as $name => $value) {
            if ($value) {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }
}

?>