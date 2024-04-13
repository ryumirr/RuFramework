<?php

namespace core\src\Http\View;
class View
{
    /* ビューファイルを格納しているviewsディレクトリへの絶対パス
     * @var string
     */
    protected $baseDir;
    /**
     * ビューファイルに変数を渡す際、デフォルトで渡す変数を設定する
     * @var array
     */
    protected $defaultValues;

    public function __construct($baseDir, $defaultValues)
    {
        $this->baseDir = $baseDir;
        $this->defaultValues = $defaultValues;
    }

    public function render($viewFileName, $customVariables = [])
    {
        $viewFilePath = $this->getViewFilePath($viewFileName);
        extract(array_merge($this->defaultValues, $customVariables));
        ob_start();
        // バファの自動フラッシュを制御する
        // 0を渡しすると自動フラッシュを無効にしています。
        ob_implicit_flush(0);
        require $viewFilePath;
        $content = ob_get_clean();
        // if ($layoutName) {
        //     $content = $this->render(
        //         $layoutName,
        //     );
        // }
        return $content;
    }

    protected function getViewFilePath($viewFile)
    {
        $dir = $this->baseDir . $viewFile;
        if (!is_dir($dir)) {
            throw new \RuntimeException('存在してないパス:' . $dir);
        }
        return $dir;
    }
}