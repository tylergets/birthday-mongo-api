<?php

namespace Tests;

class DatabaseTest extends TestCase
{
    public function test_that_a_person_can_be_created_and_retrieved()
    {
        $sample = [
            'name' => 'John Doe',
            'birthday' => '09-20-1995',
            'timezone' => 'America/New_York'
        ];

        $postResp = $this->json("POST",'/create', $sample);


        $postResp->assertResponseOk();

        $newUser = json_decode($postResp->response->getContent());

        $result = $this->json("GET",'/all');

        $result->assertResponseOk();

        $all = collect(json_decode($result->response->getContent()));

        $this->assertTrue($all->count() > 0);

        $createdResult = $all->firstWhere('_id', $newUser->_id);

        $this->assertEquals($createdResult->name, $sample['name']);
        $this->assertEquals($createdResult->timezone, $sample['timezone']);
        $this->assertEquals($createdResult->birthday, $sample['birthday']);

    }
}
