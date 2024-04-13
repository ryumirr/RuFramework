<?php
namespace core\src\Router;
class Router
{
    protected $routes;
    public function __construct($definitions)
    {
        $this->routes = $this->compileRoutes($definitions);
    }
    /**
     * ルーティング定義配列を変換するcompileRoutes()から実装しまっす。
     *
     * 1つが受け取ったルーティング定義配列中の動的パラメータ指定を正規表現で
     * 扱える形式に変換する。
     */
    public function compileRoutes($definitions)
    {
        $routes = array();
        foreach ($definitions as $url => $params) {
            // スラッシュごとに分割する。
            $tokens = explode('/', ltrim($url, '/'));
            foreach ($tokens as $index => $token) {
                if (0 === strpos($token, ':')) {
                    $name = substr($token, 1);
                    // 正規表現の形式に変換
                    $token = '(?P<)' . $name . '>[^/]+)';
                }
                $tokens[$index] = $token;
            }
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }
        return $routes;
    }

    /**
     * 変換済みのルーティング定義配列とPATH_INFOのマッチングを行いルーティング
     * パラメータの特定を行うresolve()メソッドです。
     */
    public function resolve($pathInfo)
    {
        // 先頭がスラッシュがない場合、先頭にスラッシュを付与しています。
        if (isset($pathInfo[0]) && $pathInfo[0] !== '/') {
            $pathInfo = '/' . $pathInfo;
        }
        // モジュール名を
        $moduleNameForRequest = $this->getModuleNameRequest();
        $moduleName = array_keys($this->routes);
        if (!in_array($moduleNameForRequest, $moduleName)) {
            throw new \RuntimeException('Not Found :)');
        }
        foreach ($this->routes[$moduleNameForRequest] as $pattern => $params) {
            // 変換済みのルーティング定義配列は$routesプロパティに格納されているので、
            // 正規表現を用いてマッチングします。
            if (preg_match('#^' . $pattern . '$#', $pathInfo, $matches)) {
                return array_merge($params, $matches);
            }
        }
        return false;
    }

    private function getModuleNameRequest()
    {
        $requestUrl = substr($_SERVER['REQUEST_URI'], 6);
        return substr($requestUrl, strpos($requestUrl, '/'), strpos($requestUrl, '/', 1));
    }
}
