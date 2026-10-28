<?php

declare(strict_types=1);

namespace WonderWp\Bundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WonderWp\Bundle\Loader;
use WonderWp\Component\DependencyInjection\SingletonInterface;

final class LoaderContractTest extends TestCase
{
    public function testLoaderImplementsSingletonContract(): void
    {
        $ref = new \ReflectionClass(Loader::class);
        $this->assertTrue($ref->implementsInterface(SingletonInterface::class));
        $this->assertTrue($ref->hasMethod('buildInstance'));
        $this->assertTrue($ref->getMethod('buildInstance')->isStatic());
    }
}
