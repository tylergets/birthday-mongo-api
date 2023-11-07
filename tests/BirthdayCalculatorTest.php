<?php

namespace Tests;

use App\Services\BirthdayCalculator;
use Carbon\Carbon;

// Various tests of Carbon/Carbon to ensure that we're using it correctly

class BirthdayCalculatorTest extends TestCase
{
    private function assertBirthdayIsCalculatingCorrectly(string $birthday, string $timezone, Carbon $relative, string $expected)
    {
        $calc = BirthdayCalculator::create($birthday, $timezone)->for($relative);
        $this->assertStringContainsStringIgnoringCase($expected, $calc->readable());
    }

    public function test_that_a_birthday_is_today_24_hours_left()
    {
        $today = Carbon::parse("2023-11-07 00:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "11-07-1995",
            "America/New_York",
            $today,
            "Their birthday is today. They are 28 years old. (1 day remaining in america/new_york)"
        );
    }


    public function test_that_a_birthday_is_today_19_hours_left()
    {

        $today = Carbon::parse("2023-11-07 05:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "11-07-1995",
            "America/New_York",
            $today,
            "Their birthday is today. They are 28 years old. (19 hours remaining in America/New_York)"
        );
    }

    public function test_that_a_birthday_is_today_12_hours_left()
    {

        $today = Carbon::parse("2023-11-07 12:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "11-07-1995",
            "America/New_York",
            $today,
            "Their birthday is today. They are 28 years old. (12 hours remaining in America/New_York)"
        );
    }

    public function test_that_a_birthday_is_10_days()
    {
        $today = Carbon::parse("2023-11-07 00:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "11-17-1995",
            "America/New_York",
            $today,
            "They are 27 years old. They will be 28 years old in 10 days in America/New_York"
        );
    }

    public function test_that_a_birthday_is_14_days_12_hours()
    {
        $today = Carbon::parse("2023-11-07 12:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "11-21-1995",
            "America/New_York",
            $today,
            "They are 27 years old. They will be 28 years old in 13 days, 12 hours in America/New_York"
        );
    }

    public function test_that_a_birthday_can_wrap_around()
    {
        $today = Carbon::parse("2023-11-07 12:00:00", "America/New_York");

        $this->assertBirthdayIsCalculatingCorrectly(
            "02-21-1995",
            "America/New_York",
            $today,
            "They are 28 years old. They will be 29 years old in 3 months, 13 days, 12 hours in America/New_York"
        );
    }
}
