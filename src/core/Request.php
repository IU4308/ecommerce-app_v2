<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() === 'get';
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }

    public function getBody(Model $model)
    {
        $body = [];

        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $filter = $model->getFilters($key);
                $option = 0;

                if (is_array($filter)) {
                    $option = $filter[1];
                    $filter = $filter[0];
                }

                $body[$key] = filter_input(INPUT_POST, $key, $filter, $option);
            }
        }

        if (isset($_FILES[File::FILE_ATTRIBUTE])) {
            $body['file'] = new File();
        }

        return $body;
    }
}
