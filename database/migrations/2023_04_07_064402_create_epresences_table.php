<?php

use App\Models\User;
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
        Schema::create('epresences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'user_id');
            $table->string('type');
            $table->boolean('is_approve');
            $table->timestamp('waktu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epresences');
    }
};
