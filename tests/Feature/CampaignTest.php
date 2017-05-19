<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DoeSangue\Models\User;
use DoeSangue\Models\Campaign;

class CampaignTest extends TestCase
{
    public function testCreateCampaign()
    {

        $users = factory(User::class, 3)
           ->create()
           ->each(function ($u) {
                $u->campaigns()->save(factory(Campaign::class)->make());
            });

        //  $this->assertEquals($author->id, $campaign->user_id);
          $this->assertDatabaseHas(
              'users', [
              'email' => $user->email
              ]
          );
    }
}
