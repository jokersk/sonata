<?php

namespace Sonata\Tests;

use Sonata\Sonata;
use Tests\TestCase;

class MockTest extends TestCase
{
    /** @test */
    public function can_create_mock() {
        $foo = Sonata::createMock('where()->first()->content', 'hello');
        $this->assertEquals('hello', $foo->where('abc', 123)->first()->content);
    }
}
