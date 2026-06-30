<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_views', function (Blueprint $table) {

            $table->string('visitor_hash', 64)
                ->after('user_agent');

            $table->dropUnique([
                'post_id',
                'user_id',
                'view_date'
            ]);

            $table->unique([
                'post_id',
                'visitor_hash',
                'view_date'
            ]);

        });
    }


    public function down(): void
    {
        Schema::table('post_views', function (Blueprint $table) {

            $table->dropUnique([
                'post_id',
                'visitor_hash',
                'view_date'
            ]);

            $table->unique([
                'post_id',
                'user_id',
                'view_date'
            ]);

            $table->dropColumn('visitor_hash');

        });
    }
};
