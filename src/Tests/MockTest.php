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

    /** @test */
    public function can_create_mock_with_array() {
        $foo = Sonata::createMock([
            'id' => 1,
            'value' => 2
        ]);

        $this->assertEquals(1, $foo->id);
        $this->assertEquals(2, $foo->value);

        $bar = Sonata::createMock([
            'id' => 123,
            'name()->first_name' => 'joe',
            'total()->value()->format' => '$99',
        ]);

        $this->assertEquals(123, $bar->id);
        $this->assertEquals('joe', $bar->name()->first_name);
        $this->assertEquals('$99', $bar->total()->value()->format);
    }

}
