<?php

namespace core\src\DB;

class DbManager
{
    private \PDO $dbManager;
    private string $dsn;
    private string $user;
    private string $password;
    private ?array $options;

    public function __construct(string $dsn = '', string $user = '', string $password = '', ?array $options = null)
    {
        // 1つのオプションでも空っぽなら、基本オプションに入れ替えるw
        if (!$dsn) {
            [$dsn, $user, $password] = $this->getDefaultOption();
        } elseif (!$user || !$password) {
            [, $user, $password] = $this->getDefaultOption();
        }
        $this->dsn = $dsn;
        $this->user = $user;
        $this->options = $options ?? [];
        $this->dbManager = new \PDO($this->dsn, $this->user, $this->password, $this->options);
    }
    public function clearPdoMg()
    {
        unset($this->dbManager);
    }
    public function getDb()
    {
        if (isset($this->dbManager)) {
            return $this->dbManager;
        }
        return new \PDO($this->dsn, $this->user, $this->password, $this->options);
    }

    public function getDefaultOption()
    {
        return ['mysql:dbname=testdb;host=127.0.0.1', 'rrr', 'dbpass'];
    }
}
