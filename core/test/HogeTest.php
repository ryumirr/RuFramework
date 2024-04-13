<?php
use PHPUnit\Framework\TestCase;

// テスト対象のファイルを読み込む
// require('../../programDir/Hoge.php');

class HogeTest extends TestCase
{
    public function test_TrueはTrueであること()
    {
        $this->assertTrue(True);
    }
}
