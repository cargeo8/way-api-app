<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("names");
            $table->string("surnames");
            $table->enum("id_type", ["dui", "nit", "passport"]);
            $table->string("person_id");
            $table->string("codciud");
            $table->foreign("codciud")->references("codciud")->on("municipios");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
