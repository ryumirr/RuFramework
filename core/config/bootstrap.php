<?php

/**
 * 一気に全てのクラスをrequireさせてしまった・・・
 * 必要なものだけrequireするように修正したい
 */
use core\ClassLoader;

require 'core/ClassLoader.php';

$classLoader = new ClassLoader();

// core側
$classes = glob(dirname(__FILE__, 2) . '/src/*/*.php');
$classesInner = glob(dirname(__FILE__, 2) . '/src/*/*/*.php');
$newClasses = array_merge($classes, $classesInner);
$classLoader->loadClass($newClasses);

// ユーザー側
$classes = glob(dirname(__FILE__, 3) . '/src/*/*.php');
$classesInner = glob(dirname(__FILE__, 3) . '/src/*/*/*.php');
$allClasses = array_merge($classesInner, $classes);

require 'src/Application/Application.php';
$classLoader->loadClass($allClasses);
