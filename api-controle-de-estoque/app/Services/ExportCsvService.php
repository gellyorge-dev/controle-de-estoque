<?php

namespace App\Services;

use Illuminate\Http\Response;

class ExportCsvService
{
    public function generate(array $data, array $headers = [], string $separator = ';'): string
    {
        $output = fopen('php://temp', 'r+');

        if (! empty($headers)) {
            fputcsv($output, $headers, $separator);
        }

        foreach ($data as $row) {
            fputcsv($output, $row, $separator);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }

    public function download(string $filename, array $data, array $headers = []): Response
    {
        $csv = $this->generate($data, $headers);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ]);
    }
}
