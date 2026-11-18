<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLES = ['enquiries', 'contact_messages', 'ride_requests'];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->json('status_notes')->nullable());

            DB::table($table)->whereNotNull('notes')->where('notes', '!=', '')->get(['id', 'status', 'notes'])
                ->each(fn ($row) => DB::table($table)->where('id', $row->id)->update([
                    'status_notes' => json_encode([['status' => $row->status, 'note' => $row->notes]]),
                ]));
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->dropColumn('status_notes'));
        }
    }
};
