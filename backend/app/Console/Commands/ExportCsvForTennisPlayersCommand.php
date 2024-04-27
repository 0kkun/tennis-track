<?php

namespace App\Console\Commands;

use App\Modules\ApplicationLogger;
use App\Modules\CsvExporter;
use App\Modules\FileUploader;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use TennisTrack\Player\UseCase\GetTennisPlayerList;

class ExportCsvForTennisPlayersCommand extends Command
{
    protected $signature = 'command:ExportCsvForTennisPlayers';

    protected $description = 'playersテーブルのデータをCSVに出力しS3に保存するコマンド';

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
        $players = $this->getTennisPlayerListUseCase->execute();
        $headers = array_keys($players[0] ?? []);
        $fileName = 'players_'.now()->format('Ymd_His').'.csv';

        $file = $this->csvExporter->export($headers, $players, $fileName);
        $this->fileUploader->upload(new UploadedFile($file->getPathname(), $fileName), 's3', '/exports', $fileName);
        $this->csvExporter->deleteFile($file->getPathname());

        $logger->success();
        $this->info('[ End ]');
    }
}
