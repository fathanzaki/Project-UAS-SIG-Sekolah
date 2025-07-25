<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('sekolahs', function (Blueprint $table) {
        $table->dropColumn('alamat');
    });
}

public function down()
{
    Schema::table('sekolahs', function (Blueprint $table) {
        $table->string('alamat')->after('nama'); // Jika ingin mengembalikan
    });
}
};
