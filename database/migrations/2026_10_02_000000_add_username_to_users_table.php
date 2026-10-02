<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->after('name');
        });

        $usedUsernames = [];

        DB::table('users')->orderBy('id')->get(['id', 'name'])->each(function ($user) use (&$usedUsernames) {
            $base = Str::slug((string) $user->name, '.');
            $base = $base !== '' ? $base : 'user'.$user->id;
            $username = $base;
            $suffix = 2;

            while (isset($usedUsernames[Str::lower($username)])) {
                $username = $base.$suffix;
                $suffix++;
            }

            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
            $usedUsernames[Str::lower($username)] = true;
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
            $table->unique('username');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn('username');
        });
    }
};
