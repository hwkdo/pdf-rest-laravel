<?php

namespace Hwkdo\PdfRestLaravel;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

class PdfRestLaravel
{
    protected string $api_key;

    protected string $api_url;

    public function __construct()
    {
        $this->api_key = config('pdf-rest-laravel.api_key');
        $this->api_url = config('pdf-rest-laravel.api_url');
    }

    public function getApiKey(): string
    {
        return $this->api_key;
    }

    /**
     * Get headers for API requests
     */
    protected function getHeaders(): array
    {
        return [
            'Api-Key' => $this->api_key,
            'Accept' => 'application/json',
        ];
    }

    /**
     * Convert a file to PDF using the PDF REST API
     *
     * @param  string  $filepath  Path to the file to convert
     * @return string The URL of the converted PDF
     *
     * @throws InvalidArgumentException If file does not exist
     * @throws RuntimeException If API request fails
     */
    public function convertToPdf(string $filepath): string
    {
        if (! file_exists($filepath)) {
            throw new InvalidArgumentException("File not found: {$filepath}");
        }

        $response = Http::withHeaders($this->getHeaders())
            ->attach('file', fopen($filepath, 'r'), basename($filepath))
            ->post("{$this->api_url}pdf");

        if (! $response->successful()) {
            throw new RuntimeException("PDF conversion failed: {$response->body()}");
        }

        $result = $response->json();

        if (! isset($result['outputUrl'])) {
            throw new RuntimeException('No output URL in API response');
        }

        return $result['outputUrl'];
    }

    /**
     * Convert a file to PDF and save it locally
     *
     * @param  string  $filepath  Path to the file to convert
     * @param  string|null  $outputPath  Optional output path. If null, saves in same directory as source file
     * @return string Absolute path to the saved PDF file
     *
     * @throws InvalidArgumentException If file does not exist
     * @throws RuntimeException If conversion or download fails
     */
    public function convertToPdfAndSave(string $filepath, ?string $outputPath = null): string
    {
        // Convert to PDF and get URL
        $url = $this->convertToPdf($filepath);

        // Determine output path
        if ($outputPath === null) {
            $originalFileName = pathinfo($filepath, PATHINFO_FILENAME);
            $originalDirectory = dirname($filepath);
            $outputPath = $originalDirectory.DIRECTORY_SEPARATOR.$originalFileName.'.pdf';
        }

        // Ensure output directory exists
        $outputDirectory = dirname($outputPath);
        if (! is_dir($outputDirectory)) {
            if (! mkdir($outputDirectory, 0755, true)) {
                throw new RuntimeException("Failed to create directory: {$outputDirectory}");
            }
        }

        // Download PDF
        $response = Http::get($url);

        if (! $response->successful()) {
            throw new RuntimeException("Failed to download PDF from: {$url}");
        }

        // Save to file
        if (file_put_contents($outputPath, $response->body()) === false) {
            throw new RuntimeException("Failed to save PDF to: {$outputPath}");
        }

        return realpath($outputPath);
    }
}
