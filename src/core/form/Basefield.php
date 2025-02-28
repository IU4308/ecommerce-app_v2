<?php

namespace app\core\form;

use app\core\Model;

abstract class Basefield
{
    abstract public function renderInput(): string;

    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf(
            '
            <div class="input-container">
                <label for="%s">%s:</label>
                %s
                <small class="error">%s</small>
            </div>
        ',
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}
