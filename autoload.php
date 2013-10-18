<?php
/**
 *  Autoload
 */

spl_autoload_register(function($class) {
	$path = preg_split('/\\\\/', $class, -1, PREG_SPLIT_NO_EMPTY);
	if ('F3' === reset($path)) {
		array_unshift($path, __DIR__, 'src');
		require_once(implode(DIRECTORY_SEPARATOR, $path) . '.php');
	}
}, true, false);
