<?php

namespace App\Exports;

use App\Repositories\BaseRepository;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Repositories\CountryRepository;

class CountriesExport extends QueryExport implements WithHeadings
{
  public function repository(): BaseRepository
  {
    return app(CountryRepository::class);
  }

  public function allowedExports(): array
  {
    return [
      AllowedExport::column('id', 'ID'),
      AllowedExport::column('name', 'Name'),
      AllowedExport::column('native', 'Native'),
      AllowedExport::column('region', 'Region'),
      AllowedExport::column('created_at', 'Created At'),
      AllowedExport::column('updated_at', 'Updated At'),
    ];
  }
}
