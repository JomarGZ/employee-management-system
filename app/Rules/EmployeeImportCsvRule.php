<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmployeeImportCsvRule implements ValidationRule
{
     protected $requiredHeaders;

    public function __construct(array $requiredHeaders)
    {
        $this->requiredHeaders = $requiredHeaders;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value->isValid()) {
            $fail('The uploaded file is not valid.');
            return;
        }

        // Get the first row (headers) from CSV
        $stream = fopen($value->getPathname(), 'r');
        $headers = fgetcsv($stream);
        fclose($stream);
        $cleanHeaders = array_map(function ($header) {
            $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header);
            return strtolower(trim($header));
        }, $headers);
        $headersWithoutId = array_filter($cleanHeaders, fn ($header) => !empty($header) && $header !== 'id');
        
        $requiredHeaders = array_map('strtolower', $this->requiredHeaders);

        // Check if all required headers exist
        $missingHeaders = array_diff($requiredHeaders, $headersWithoutId);
        
        $unexpectedHeaders = array_diff($headersWithoutId,$requiredHeaders);

        if (count($missingHeaders) > 0) {
            $fail('The CSV file is missing required headers: ' . implode(', ', $missingHeaders));
            return;
        }
        
        if (count($unexpectedHeaders) > 0) {
            $fail('The CSV file has an unexpected headers: ' . implode(', ', $unexpectedHeaders));
            return;
        }
    }
}
