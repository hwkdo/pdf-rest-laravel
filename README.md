# This is my package pdf-rest-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hwkdo/pdf-rest-laravel.svg?style=flat-square)](https://packagist.org/packages/hwkdo/pdf-rest-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hwkdo/pdf-rest-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hwkdo/pdf-rest-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hwkdo/pdf-rest-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hwkdo/pdf-rest-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hwkdo/pdf-rest-laravel.svg?style=flat-square)](https://packagist.org/packages/hwkdo/pdf-rest-laravel)

Ein Laravel-Package zur Integration mit der PDF REST API. Konvertieren Sie Dokumente verschiedenster Formate einfach in PDF-Dateien.

## Installation

Sie können das Package via Composer installieren:

```bash
composer require hwkdo/pdf-rest-laravel
```

## Konfiguration

Sie können die Konfigurationsdatei veröffentlichen mit:

```bash
php artisan vendor:publish --tag="pdf-rest-laravel-config"
```

Inhalt der Konfigurationsdatei:

```php
return [
    'api_key' => env('PDF_REST_API_KEY'),
    'api_url' => env('PDF_REST_API_URL', 'https://eu-api.pdfrest.com/'),
];
```

Fügen Sie Ihren API-Key zu Ihrer `.env` Datei hinzu:

```env
PDF_REST_API_KEY=your-api-key-here
PDF_REST_API_URL=https://eu-api.pdfrest.com/
```

## Verwendung

### Datei zu PDF konvertieren und URL erhalten

Konvertieren Sie eine Datei zu PDF und erhalten Sie die URL der konvertierten Datei:

```php
use Hwkdo\PdfRestLaravel\Facades\PdfRestLaravel;

$url = PdfRestLaravel::convertToPdf('/path/to/document.docx');
// Gibt zurück: "https://eu-api.pdfrest.com/output/abc123.pdf"
```

### Datei zu PDF konvertieren und lokal speichern

#### Im gleichen Verzeichnis wie die Originaldatei speichern

```php
use Hwkdo\PdfRestLaravel\Facades\PdfRestLaravel;

$path = PdfRestLaravel::convertToPdfAndSave('/path/to/document.docx');
// Gibt zurück: "/path/to/document.pdf"
```

#### An einem benutzerdefinierten Ort speichern

```php
use Hwkdo\PdfRestLaravel\Facades\PdfRestLaravel;

$path = PdfRestLaravel::convertToPdfAndSave(
    '/path/to/document.docx',
    '/custom/output/myfile.pdf'
);
// Gibt zurück: "/custom/output/myfile.pdf"
```

### Fehlerbehandlung

Beide Methoden werfen Exceptions bei Fehlern:

```php
use Hwkdo\PdfRestLaravel\Facades\PdfRestLaravel;
use InvalidArgumentException;
use RuntimeException;

try {
    $path = PdfRestLaravel::convertToPdfAndSave('/path/to/document.docx');
    echo "PDF erfolgreich gespeichert: {$path}";
} catch (InvalidArgumentException $e) {
    // Datei existiert nicht
    echo "Fehler: {$e->getMessage()}";
} catch (RuntimeException $e) {
    // API-Fehler oder Download-Fehler
    echo "Fehler: {$e->getMessage()}";
}
```

### Unterstützte Dateiformate

Die PDF REST API unterstützt viele Dokumentformate, darunter:
- Microsoft Office: .docx, .doc, .xlsx, .xls, .pptx, .ppt
- Bilder: .jpg, .jpeg, .png, .gif, .bmp, .tiff
- Andere: .html, .txt, und viele weitere

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [hwkdo](https://github.com/hwkdo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
