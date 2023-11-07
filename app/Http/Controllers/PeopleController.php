<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Rules\Birthday;
use App\Rules\Timezone;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        $people = Person::all();
        return response()->json($people);
    }

    public function createNew(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'birthday' => ['required', new Birthday],
            'timezone' => ['required', new Timezone]
        ]);

        $person = new Person();
        $person->name = $request->get('name');
        $person->birthday = $request->get('birthday');
        $person->timezone = $request->get('timezone');
        $person->save();

        return response()->json($person);
    }
}
