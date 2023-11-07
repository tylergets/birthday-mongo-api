<?php

namespace App\Services;

use Carbon\Carbon;

class BirthdayCalculator
{

    public string $timezone;

    public Carbon $since;

    public Carbon $birthday;

    public function __construct($birthday, $timezone)
    {

        // Hold onto this for later if needed
        $this->timezone = $timezone;

        // A birthday is midnight in that persons timezone
        $this->birthday = Carbon::createFromFormat('m-d-Y', $birthday, $timezone)
            ->startOf('day')
            ->shiftTimezone('UTC');

        $this->since = Carbon::now('UTC');
    }

    public function for(Carbon $referenceTime): BirthdayCalculator
    {
        $this->since = $referenceTime->shiftTimezone('UTC');
        return $this;
    }

    public static function create(string $birthday, string $timezone): BirthdayCalculator
    {
        return new static($birthday, $timezone);
    }

    public function isBirthdayToday()
    {
        return $this->since->isSameDay($this->birthdayThisYear());
    }

    public function yearsOld()
    {
        return $this->since->diffInYears($this->birthday);
    }

    public function timeBetween(Carbon $start, Carbon $end)
    {

        echo "START: " . $start;
        echo "END: " . $end;

        $diffInMonths = $start->diffInMonths($end);
        $startAfterMonths = $start->clone()->addMonths($diffInMonths);

        $diffInDays = $startAfterMonths->diffInDays($end);
        $startAfterDays = $startAfterMonths->addDays($diffInDays);

        $diffInHours = $startAfterDays->diffInHours($end);
        $startAfterHours = $startAfterDays->addHours($diffInHours);

        $diffInMinutes = $startAfterHours->diffInMinutes($end);

        $parts = [
            'month' => $diffInMonths,
            'day' => $diffInDays,
            'hour' => $diffInHours,
            'minute' => $diffInMinutes,
        ];

        // combine this into a string
        return collect($parts)
            ->map(function ($value, $key) {
                if ($value === 0) {
                    return '';
                }
                // Add an 's' at the end of the unit if value is not 1.
                $unit = $value === 1 ? $key : "{$key}s";
                return "{$value} {$unit}";
            })
            ->filter() // Remove the empty strings from the collection
            ->join(', '); // Join the parts with a comma and a space
    }

    public function print(string $name): string
    {
        return "Hello, $name! " . $this->readable();
    }

    public function readable(): string
    {
        $yearsOld = $this->yearsOld();

        if ($this->isBirthdayToday()) {
            return "Their birthday is today. They are {$yearsOld} years old. ({$this->timeBetween(
                $this->since->clone(),
                $this->since->clone()->endOfDay()->addMicro()
            )} remaining in {$this->timezone})";
        }

        $nextBirthday = $this->nextBirthday();
        $nextAge = $yearsOld + 1;

        return "They are {$yearsOld} years old. They will be {$nextAge} years old in {$this->timeBetween(
            $this->since,
            $nextBirthday
        )} in {$this->timezone}";
    }
    public function birthdayThisYear(): Carbon
    {
        return $this->birthday->clone()->setYear($this->since->year);
    }

    public function nextBirthday(): Carbon
    {
        $next = $this->birthdayThisYear();

        if ($next->lessThan($this->since)) {
            return $next->clone()->addYear();
        }

        return $next;
    }
}
