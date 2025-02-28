<?php

namespace app\core;

use app\core\DbModel;

abstract class ProductModel extends DbModel
{
    public ?File $file = null;
    public string $filename = '';

    public function validate()
    {
        $nonfile_validation = parent::validate();

        $file_validation = $this->file->validate();

        $this->filename = $this->file->filename;

        if ($nonfile_validation && $file_validation) {
            return true;
        } else {
            $this->errors['filename'][] = $this->file->getError();
            return false;
        }
    }

    public function save()
    {
        if ($this->tableName() === 'cart') {
            return parent::save();
        }
        if ($this->file->upload()) {
            return parent::save();
        } else {
            $errorMsg = $this->file->getError();
            $this->errors['filename'][] = $errorMsg;
            new Log($errorMsg, 'ERROR');
            return false;
        }
    }
}
