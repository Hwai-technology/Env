<?php

declare(strict_types=1);

use EnvLib\EnvManager;
use PHPUnit\Framework\TestCase;

final class EnvManagerTest extends TestCase
{
    private string $envFile;

    protected function setUp(): void
    {
        $this->envFile = __DIR__ . '/.env.test';
        file_put_contents($this->envFile, <<<ENV
# Comment line
; Another comment
APP_NAME="MyApp"
DEBUG=true
PORT=8080
PI=3.14
EMPTY=
NULL=null
ENABLED=false
ENV);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->envFile)) {
            unlink($this->envFile);
        }
    }

    public function testLoadAndGet(): void
    {
        $env = new EnvManager($this->envFile);

        $this->assertTrue($env->has('APP_NAME'));
        $this->assertSame('MyApp', $env->get('APP_NAME'));
        $this->assertTrue($env->get('DEBUG'));
        $this->assertSame(8080, $env->get('PORT'));
        $this->assertSame(3.14, $env->get('PI'));
        $this->assertNull($env->get('NULL'));
        $this->assertFalse($env->get('ENABLED'));
        $this->assertSame('', $env->get('EMPTY'));
        $this->assertNull($env->get('NOT_EXISTING'));
        $this->assertSame('default', $env->get('NOT_EXISTING', 'default'));
    }

    public function testSetAndSave(): void
    {
        $env = new EnvManager($this->envFile);
        $env->set('NEW_KEY', 'new_value');
        $env->set('DEBUG', false);
        $env->set('PORT', 1234);
        $savePath = __DIR__ . '/.env.saved';
        $env->save($savePath);

        $saved = new EnvManager($savePath);
        $this->assertSame('new_value', $saved->get('NEW_KEY'));
        $this->assertFalse($saved->get('DEBUG'));
        $this->assertSame(1234, $saved->get('PORT'));

        unlink($savePath);
    }

    public function testAll(): void
    {
        $env = new EnvManager($this->envFile);
        $all = $env->all();
        $this->assertIsArray($all);
        $this->assertArrayHasKey('APP_NAME', $all);
        $this->assertArrayHasKey('DEBUG', $all);
    }
}
