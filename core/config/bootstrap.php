<?php

/**
 * 一気に全てのクラスをrequireさせてしまった・・・
 * 必要なものだけrequireするように修正したい
 */
use core\ClassLoader;

require 'core/ClassLoader.php';

$classLoader = new ClassLoader();

// ユーザー側
$classes = glob(dirname(__FILE__, 3) . '/src/*/*.php');
$classesInner = glob(dirname(__FILE__, 3) . '/src/*/*/*.php');
$newClasses = array_merge($classesInner, $classes);

// core側
$classes = glob(dirname(__FILE__, 2) . '/src/*/*.php');
$classesInner = glob(dirname(__FILE__, 2) . '/src/*/*/*.php');
 
// 合体
$allClasses = array_merge($newClasses, $classesInner, $classes);

require 'core/src/Http/Response/ApiResponse.php';
require 'core/src/Controllers/Controller.php';
require 'src/Application/Application.php';

foreach ($allClasses as $class) {
    $classLoader->loadClass($class);
}
