<?php

namespace App\Console\Commands;

use App\Modules\ApplicationLogger;
use Illuminate\Console\Command;
use TennisTrack\Player\UseCase\GetTennisPlayerList;
use App\Modules\FileUploader;
use Illuminate\Http\UploadedFile;
use App\Modules\CsvExporter;

class CsvExportForTennisPlayers extends Command
{
    protected $signature = 'command:ExportCsvForTennisPlayers';

    protected $description = 'playersテーブルのデータをCSVにエクスポートするコマンド';

    /**
     * @param GetTennisPlayerList $getTennisPlayerListUseCase
     * @param CsvExporter $csvExporter
     * @param FileUploader $fileUploader
     */
    public function __construct(
        private GetTennisPlayerList $getTennisPlayerListUseCase,
        private CsvExporter $csvExporter,
        private FileUploader $fileUploader
    ) {
        parent::__construct();
        $this->getTennisPlayerListUseCase = $getTennisPlayerListUseCase;
        $this->csvExporter = $csvExporter;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $logger = new ApplicationLogger(__METHOD__);
        $this->info('[ Start ]');
        $players = $this->getTennisPlayerListUseCase->execute($limit = 10);
        $headers = array_keys($players[0] ?? []);
        $fileName = 'players_'.now()->format('Ymd_His').'.csv';
        // TODO: storageディレクトリに保存するように変更
        $file = $this->csvExporter->export($headers, $players, $fileName);
        $this->fileUploader->upload(new UploadedFile($file->getPathname(), $fileName), 's3', '/exports', $fileName);
        $logger->success();
        $this->info('[ End ]');
    }
}
