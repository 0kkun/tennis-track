<?php

namespace Database\Seeders;

use App\Eloquents\EloquentPlayer;
use App\Modules\CsvImporter;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class PlayerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $file = new UploadedFile(storage_path('app/csv').'/players.csv', 'players.csv');
        $importer = new CsvImporter($file);
        $data = $importer->import();
        EloquentPlayer::insert($data);
    }
}
