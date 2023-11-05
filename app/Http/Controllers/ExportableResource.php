<?php

namespace App\Http\Controllers;

use App\Exports\QueryExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ExportableResource
{
  public function export(Request $request)
  {
    $validated = $request->validate([
      'format' => 'sometimes|in:xlsx,csv',
      'importable' => 'sometimes|in:true,false',

      'csv.delimiter' => 'sometimes|string',

      'csv.enclosure' => [
        'sometimes',
        'string',
        Rule::in(['"', "'"]),
      ],

      'csv.line_ending' => [
        'sometimes',
        'string',
        Rule::in(["\r\n", "\n", "\r"]),
      ],

      'csv.use_bom' => 'sometimes|boolean',
      'csv.include_separator_line' => 'sometimes|boolean',
      'csv.excel_compatibility' => 'sometimes|boolean',
    ]);

    $exporter = $this->exporter();

    // If the exporter is a string, we will resolve it from the container.
    if (is_string($exporter)) {
      $exporter = app($exporter);
    }

    $exporter->setCsvSettings($validated['csv'] ?? []);

    $exporter->setImportable($request->boolean('importable', false));

    $format = $request->input('format', 'csv');

    $user = $request->user();

    $filename = $this->generateFileName($format);

    $exporter
      // ->download($filename);

      ->queue($filename)
      ->chain([
        new NotifyUserOfCompletedExport($user, $filename),
      ]);

    return response()->json([
      'success' => true,
      'message' => 'Export started, you will be notified when it is completed.',
    ]);
  }

  private function generateFileName(string $format)
  {
    $uniqueId = uniqid($this->exportPrefixName());

    return "{$uniqueId}.{$format}";
  }

  /**
   * Get the exporter instance.
   *
   * @return string|\App\Exports\QueryExport
   */
  public abstract function exporter(): string|QueryExport;

  /**
   * Get the export prefix for the resource.
   *
   * @return string
   */
  public function exportPrefixName(): string
  {
    $name = class_basename($this);

    $name = str_replace('Controller', '', $name);

    $name = strtolower($name);

    return \Str::plural($name) . '-export-';
  }
}
