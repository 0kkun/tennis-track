<?php

namespace App\Modules;

use Carbon\Carbon;

class CsvImporter extends AbstractCsvImporter
{
    /**
     * CSVインポートを行う
     *
     * @param array|null $rules
     * @param array $customMessages
     * @return array
     */
    public function import(array $rules = null, array $customMessages = []): array
    {
        if (! is_null($rules)) {
            $errors = $this->validateRows($rules, $customMessages);
            if (count($errors) > 0) {
                return $errors;
            }
        }

        $results = [];
        foreach ($this->getCsvRows() as $row) {
            // CSVの各行を加工

            // FIXME: いい感じに外部からこの処理を注入できるようにする
            if (isset($row['created_at'])) {
                $row['created_at'] = Carbon::parse($row['created_at'])->format('Y-m-d H:i:s');
            }
            if (isset($row['updated_at'])) {
                $row['updated_at'] = Carbon::parse($row['updated_at'])->format('Y-m-d H:i:s');
            }
            if (isset($row['pro_year'])) {
                $row['pro_year'] = ! empty($row['pro_year']) ? (int) $row['pro_year'] : null;
            }

            $results[] = $row;
        }

        return $results;
    }
}
