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
            $table->string('phone')->nullable()->after('email');
            $table->foreignId('role_id')->default(1)->after('password');
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active')->after('role_id');
            $table->string('preferred_language', 2)->default('en')->after('status');
            $table->timestamp('last_login_at')->nullable()->after('preferred_language');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->integer('failed_login_attempts')->default(0)->after('last_login_ip');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'role_id', 'status', 'preferred_language', 
                'last_login_at', 'last_login_ip', 'failed_login_attempts', 'locked_until'
            ]);
        });
    }
};
