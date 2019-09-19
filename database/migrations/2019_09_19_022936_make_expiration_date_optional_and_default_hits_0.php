<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeExpirationDateOptionalAndDefaultHits0 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('links')) {
            Schema::table('links', function (Blueprint $table) {
                $table->dateTime('expiration_date')->nullable()->change();
                $table->unsignedBigInteger('hits')->default(0)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dateTime('expiration_date')->change();
            $table->unsignedBigInteger('hits')->change();
        });
    }
}
