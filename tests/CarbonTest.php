<?php

namespace Tests;

use Carbon\Carbon;

// Various tests of Carbon/Carbon to ensure that we're using it correctly

class CarbonTest extends TestCase
{
    public function test_that_a_carbon_birthday_is_midnight()
    {


        $birthday = "09-20-1995";
        $timezone = "America/New_York";

        $test = Carbon::createFromFormat('m-d-Y', $birthday, $timezone)->startOf('day');

        $this->assertEquals($test->hour, 0);
        $this->assertEquals($test->minute, 0);
        $this->assertEquals($test->second, 0);
        $this->assertEquals($test->micro, 0);
    }
}
