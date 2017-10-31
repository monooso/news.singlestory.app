<?php

namespace Tests\Unit;

use Tests\TestCase;

class CollectionMacrosTest extends TestCase
{
    /** @test */
    public function it_should_order_by_popularity()
    {
        $input = collect([
            $this->objectify(['title' => 'Third', 'popularity' => 1]),
            $this->objectify(['title' => 'First', 'popularity' => 100]),
            $this->objectify(['title' => 'Second', 'popularity' => 10]),
        ]);

        $result = $input->mostPopular();

        $this->assertEquals($input[1], $result[0]);
        $this->assertEquals($input[2], $result[1]);
        $this->assertEquals($input[0], $result[2]);
    }

    /** @test */
    public function it_should_limit_the_results_if_count_is_specified()
    {
        $input = collect([
            $this->objectify(['title' => 'Third', 'popularity' => 1]),
            $this->objectify(['title' => 'First', 'popularity' => 100]),
            $this->objectify(['title' => 'Second', 'popularity' => 10]),
        ]);

        $result = $input->mostPopular(1);

        $this->assertSame(1, $result->count());
    }

    /** @test */
    public function it_should_return_all_results_if_no_count_is_specified()
    {
        $input = collect([
            $this->objectify(['title' => 'Third', 'popularity' => 1]),
            $this->objectify(['title' => 'First', 'popularity' => 100]),
            $this->objectify(['title' => 'Second', 'popularity' => 10]),
        ]);

        $result = $input->mostPopular();

        $this->assertSame(3, $result->count());
    }
}
