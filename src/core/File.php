<?php

namespace app\core;

class File
{
    public const FILE_ATTRIBUTE = 'filename';

    const ALLOWED_FILES = [
        'image/png' => 'png',
        'image/jpeg' => 'jpg'
    ];

    const MAX_SIZE = 5 * 1024 * 1024; //  5MB

    const MESSAGES = [
        UPLOAD_ERR_OK => 'File uploaded successfully',
        UPLOAD_ERR_INI_SIZE => 'File is too big to upload',
        UPLOAD_ERR_FORM_SIZE => 'File is too big to upload',
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server',
        UPLOAD_ERR_CANT_WRITE => 'File is failed to save to disk.',
        UPLOAD_ERR_EXTENSION => 'File is not allowed to upload to this server',
    ];

    public static string $UPLOAD_DIR;

    public string $filename = '';
    public int $status = 0;
    public string $tmp = '';
    public int $size = 0;
    public string $mime_type = '';
    public string $uploaded_file = '';
    public string $filepath = '';

    public array $errors = [];


    public function __construct($attribute = self::FILE_ATTRIBUTE)
    {
        self::$UPLOAD_DIR = Application::$ROOT_DIR . "/public/uploads";

        if (isset($_FILES[$attribute])) {
            $this->filename = uniqid() . $_FILES[$attribute]['name'];
            $this->status = $_FILES[$attribute]['error'];
            $this->tmp = $_FILES[$attribute]['tmp_name'];
        } else {
            $this->errors[] = 'Invalid file upload operation';
        }
    }

    public function validate()
    {
        if ($this->status !== UPLOAD_ERR_OK) {
            $this->errors[] = self::MESSAGES[$this->status];

            Application::$app->session->setFlash('test', '1488');
            return false;
        }

        $this->size = filesize($this->tmp);
        $this->mime_type = $this->get_mime_type($this->tmp);

        if ($this->size > self::MAX_SIZE) {
            $this->errors[] = 'Error! your file size is ' . $this->format_filesize($this->size) . ' , which is bigger than allowed size ' . $this->format_filesize(self::MAX_SIZE);
            return false;
        }

        if (!in_array($this->mime_type, array_keys(self::ALLOWED_FILES))) {
            $this->errors[] = 'The file type is not allowed to upload';
            return false;
        }

        return true;
    }


    public function upload()
    {
        $this->uploaded_file = pathinfo($this->filename, PATHINFO_FILENAME) . '.' . self::ALLOWED_FILES[$this->mime_type];
        // new file location
        $this->filepath = self::$UPLOAD_DIR . '/' . $this->uploaded_file;

        // move the file to the upload dir
        $success = move_uploaded_file($this->tmp, $this->filepath);

        if (!$success) {
            $this->errors[] = 'Error moving the file to the upload folder.';
        }

        return empty($this->errors);
    }

    public function get_mime_type(string $filename)
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);
        if (!$info) {
            return false;
        }

        $mime_type = finfo_file($info, $filename);
        finfo_close($info);

        return $mime_type;
    }

    public function format_filesize(int $bytes, int $decimals = 2): string
    {
        $units = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $units[(int)$factor];
    }

    public function getError()
    {
        return $this->errors[0];
    }
}
