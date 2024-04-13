<?php

namespace core;

class ClassLoader
{
    protected $dirs;

    /**
     * PHPにオートローダクラスを登録する処理です。
     */
    public function register()
    {
       spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * coreディレクトリとmodelsディレクトリからクラスファイルの読み込みを行うようにしますが、
     * より柔軟にするため探すディレクトリを幾つでも登録できるような仕組みにします。
     * そこで、ディレクトリを登録するのがregisterDir()！
     *
     */
    public function registerDir($dir)
    {
        $this->dirs[] = $dir;
    }

    /**
     * loadClassメソッドはオートロード時にPHPから自動的に呼び出され、クラスファイルの読み込みを
     * 行う処理です。
     */
    public function loadClass($class)
    {
        //foreach ($this->dirs[0] as $file) {
            // var_dump($class);
            //$file = $dir . '/' . $class . '.php';
           // var_dump($file);
           if (is_readable($class)) {
                require_once $class;
              //  return;
            }
       // }
    }
}
