<?php

namespace GiveBlood\Modules\Users\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitesTable extends Migration
{
    /**
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create(
            'invites', function (Blueprint $table) {
                $table->increments('id');
                $table->string('invite_code')->unique();
                $table->uuid('user_id');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('invites');
    }
}
