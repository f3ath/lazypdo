<?php
spl_autoload_register(function($class) {
    $file = __DIR__.'/src/'.str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (is_file($file)) {
        require_once($file);
    }
});
