<?php

namespace App\Modules;

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
        if (!is_null($rules)) {
            $errors = $this->validateRows($rules, $customMessages);
            if (count($errors) > 0) {
                return $errors;
            }
        }

        $results = [];
        foreach ($this->getCsvRows() as $row) {
            // CSVの各行を加工
            $results[] = $row;
        }

        return $results;
    }
}