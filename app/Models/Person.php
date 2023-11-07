<?php

namespace App\Models;

use App\Services\BirthdayCalculator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;

class Person extends Model
{
    protected $collection = 'people';

    protected $appends = ['birthday_warning'];

    protected $fillable = [
        'name',
        'birthday',
        'timezone'
    ];

    protected function birthdayWarning(): Attribute
    {
        return new Attribute(
            get: function () {
                try {
                    return BirthdayCalculator::create($this->birthday, $this->timezone)->print($this->name);
                } catch (\Exception $e) {
                    return 'Error calculating birthday: ' . $e->getMessage();
                }
            },
        );
    }

}
