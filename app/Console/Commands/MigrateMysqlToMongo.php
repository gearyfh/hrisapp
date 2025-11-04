<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateMysqlToMongo extends Command
{
    protected $signature = 'migrate:mysql-to-mongo';
    protected $description = 'Migrasi semua tabel dari MySQL ke MongoDB';

    public function handle()
    {
        $mysql = DB::connection('mysql');
        $mongo = DB::connection('mongodb');

        $database = $mysql->getDatabaseName();
        $tables = $mysql->select('SHOW TABLES');
        $key = 'Tables_in_' . $database;

        foreach ($tables as $table) {
            $tableName = $table->$key;
            $this->info("Migrating table: {$tableName}");

            $rows = $mysql->table($tableName)->get();

            if ($rows->isEmpty()) {
                $this->warn("  → Table {$tableName} is empty, skipped.");
                continue;
            }

            $docs = $rows->map(fn($row) => (array) $row)->toArray();

            $mongo->collection($tableName)->insertMany($docs);

            $this->info("  → Inserted " . count($docs) . " documents into MongoDB collection '{$tableName}'");
        }

        $this->info("✅ Migrasi selesai!");
    }
}
