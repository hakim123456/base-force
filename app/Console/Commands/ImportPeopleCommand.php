<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportPeopleCommand extends Command
{
    protected $signature = 'app:import-people';

    protected $description = 'Import people from the extremist elements CSV file';

    public function handle()
    {
        $filePath = 'C:\Users\LENOVO\Downloads\traitement nom (1).xlsx - العناصر المتطرفة.csv';

        if (!file_exists($filePath)) {
            $this->error("File not found at: $filePath");
            return 1;
        }

        $file = new \SplFileObject($filePath, 'r');
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD | \SplFileObject::DROP_NEW_LINE);
        
        $header = $file->fgetcsv(); // Skip header
        $count = 0;
        $skipped = 0;

        $this->info('Starting import...');
        // Total count is approximately 4762 based on previous check
        $bar = $this->output->createProgressBar(4762);

        while (!$file->eof()) {
            $row = $file->fgetcsv();
            // Basic validation of row content
            if (!$row || count($row) < 18) continue;

            $identifier = trim($row[17]);
            if (empty($identifier)) {
                $skipped++;
                continue;
            }

            // Check if exists to prevent duplicates
            if (\App\Models\Person::where('identifier', $identifier)->exists()) {
                $skipped++;
                continue;
            }

            $spouseCol = trim($row[9]);
            $maritalStatus = null;
            $spouseName = null;

            // Logic to determine marital status and spouse name from CSV column 9
            if (in_array($spouseCol, ['أعزب', 'أعزبة', 'اعزب', 'اعزبة'])) {
                $maritalStatus = 'أعزب/عزباء';
            } elseif (str_contains($spouseCol, 'متزوج')) {
                $maritalStatus = 'متزوج/متزوجة';
                $spouseName = trim(str_replace('متزوج', '', $spouseCol));
            } elseif (in_array($spouseCol, ['مطلق', 'مطلقة'])) {
                $maritalStatus = 'مطلق/مطلقة';
            } elseif (in_array($spouseCol, ['أرمل', 'أرملة'])) {
                $maritalStatus = 'أرمل/أرملة';
            } elseif (!empty($spouseCol)) {
                $maritalStatus = 'متزوج/متزوجة';
                $spouseName = $spouseCol;
            }

            \App\Models\Person::create([
                'first_name' => trim($row[1]),
                'father_name' => trim($row[2]),
                'grandfather_name' => trim($row[3]),
                'last_name' => trim($row[4]),
                'dob' => trim($row[5]),
                'mother_name' => trim($row[7]),
                'gender' => trim($row[8]),
                'marital_status' => $maritalStatus,
                'spouse_name' => $spouseName ?: null,
                'job' => trim($row[10]),
                'country' => trim($row[11]),
                'governorate' => trim($row[12]),
                'delegation' => trim($row[13]),
                'sector' => trim($row[14]),
                'address' => trim($row[16]),
                'identifier' => $identifier,
                'phone' => trim($row[21]),
                'notes' => trim($row[24] ?? ''),
            ]);

            $count++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Import completed: $count records imported, $skipped records skipped.");

        return 0;
    }
}
