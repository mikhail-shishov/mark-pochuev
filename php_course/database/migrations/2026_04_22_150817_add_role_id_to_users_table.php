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
        if (Schema::hasTable('roles')) {
             $roles = [
                'admin' => \DB::table('roles')->where('slug', 'admin')->value('id'),
                'moderator' => \DB::table('roles')->where('slug', 'moderator')->value('id'),
                'user' => \DB::table('roles')->where('slug', 'user')->value('id'),
            ];
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            }
        });

        $users = \DB::table('users')->get();
        foreach ($users as $user) {
            $roleSlug = $user->role ?? 'user';
            $roleId = \DB::table('roles')->where('slug', $roleSlug)->value('id');
            if ($roleId) {
                \DB::table('users')->where('id', $user->id)->update(['role_id' => $roleId]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
