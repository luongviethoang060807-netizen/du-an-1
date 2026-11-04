<?php

session_start();

require_once __DIR__ . '/configs/env.php';
require_once __DIR__ . '/configs/helper.php';
// require_once __DIR__ . '/extensions/VipUpload.php';


set_exception_handler('handleGlobalError');
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});


spl_autoload_register(function ($class) {
    $fileName = "$class.php";
    $fileModel = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    //Khai bao them phan Extensions mo rong
    $fileExtension = PATH_EXTENSION . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } else if (is_readable($fileController)) {
        require_once $fileController;
    } else if (is_readable($fileExtension)) {
        require_once $fileExtension;
    }
});


// Điều hướng
require_once __DIR__ . '/routes/index.php';
