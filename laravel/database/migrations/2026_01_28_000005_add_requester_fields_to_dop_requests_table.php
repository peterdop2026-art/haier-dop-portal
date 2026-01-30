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
        Schema::table('dop_requests', function (Blueprint $table) {
            $table->string('requester_name')->nullable()->after('case_type');
            $table->string('requester_branch')->nullable()->after('requester_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dop_requests', function (Blueprint $table) {
            $table->dropColumn(['requester_name', 'requester_branch']);
        });
    }
};
