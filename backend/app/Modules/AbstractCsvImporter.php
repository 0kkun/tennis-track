<?php

namespace App\Modules;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

abstract class AbstractCsvImporter
{
    protected UploadedFile $file;
    /* CSVファイルの区切り文字 */
    protected string $delimiter;
    /* CSVファイルにヘッダー行があるかどうかのフラグ */
    protected bool $hasHeaderRow = true;
    /* CSVファイルの最大行数 */
    protected const MAX_ROWS = 10000;

    /**
     * @param UploadedFile $file CSVファイルを格納するUploadedFileクラスのインスタンス
     * @param string $delimiter CSVファイルの区切り文字
     */
    public function __construct(UploadedFile $file, string $delimiter = ',')
    {
        $this->file = $file;
        $this->delimiter = $delimiter;
    }

    /**
     * CSVファイルのバリデーションを行う
     *
     * @return void
     * @throws \Exception
     */
    protected function validateCsvFile()
    {
        if (!$this->file->isValid()) {
            throw new \Exception('CSV file not found.');
        }

        if (!$this->file->isReadable()) {
            throw new \Exception('Unable to read CSV file.');
        }

        if (count(file($this->file)) > self::MAX_ROWS) {
            throw new \Exception('CSV file has too many rows.');
        }
    }

    /**
     * CSVファイルを読み込み、ジェネレータを返す
     *
     * @return \Generator
     */
    protected function getCsvRows(): \Generator
    {
        $file = new \SplFileObject($this->file);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        $this->validateCsvFile();

        $header = $this->hasHeaderRow ? $file->fgetcsv($this->delimiter) : null;

        foreach ($file as $index => $row) {
            if ($row === [null]) {
                continue;
            }

            if ($this->hasHeaderRow && $index === 0) {
                continue;
            }

            if ($this->hasHeaderRow) {
                // [header名 => データ] という連想配列に変換
                yield array_combine($header, $row);
            } else {
                yield $row;
            }
        }
    }

    /**
     * 行ごとにバリデーションを行う
     *
     * @param array $rules バリデーションルールの配列
     * @param array $customMessages カスタムエラーメッセージの配列
     * @return array
     */
    protected function validateRows(array $rules, $customMessages = []): array
    {
        $validator = Validator::make([], $rules, $customMessages);

        foreach ($this->getCsvRows() as $row) {
            $validator->setData($row);
            $validator->validate();
        }
        return $validator->errors()->toArray();
    }

    /**
     * CSVインポートを行う
     *
     * @param array|null $rules
     * @param array $customMessages
     * @return array
     */
    abstract public function import(array $rules = null, array $customMessages = []): array;
}