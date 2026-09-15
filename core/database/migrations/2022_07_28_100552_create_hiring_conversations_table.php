<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hiring_conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hiring_id')->default(0);
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('influencer_id')->default(0);
            $table->string('sender',40)->nullable();
            $table->text('message')->nullable();
            $table->text('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hiring_conversations');
    }
};
