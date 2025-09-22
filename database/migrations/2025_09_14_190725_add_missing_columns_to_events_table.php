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
        Schema::table('events', function (Blueprint $table) {
            $table->text('content')->nullable()->after('description');
            $table->string('location_url')->nullable()->after('location');
            $table->boolean('publish_status')->default(false)->after('location_url');
            $table->enum('event_type', ['online', 'in-person', 'hybrid'])->default('in-person')->after('publish_status');
            $table->timestamp('published_at')->nullable()->after('event_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'content',
                'location_url', 
                'publish_status',
                'event_type',
                'published_at'
            ]);
        });
    }
};
