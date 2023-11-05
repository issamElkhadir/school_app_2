<?php

namespace App\Exports;
use App\Repositories\BaseRepository;
use App\Repositories\StateRepository;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StatesExport extends QueryExport implements WithMapping, WithHeadings
{
  public function repository(): BaseRepository
  {
    return app(StateRepository::class);
  }

  public function allowedExports(): array
  {
    return [
      AllowedExport::column('id', 'ID'),
      AllowedExport::column('name', 'Name'),
      AllowedExport::belongsTo('country', 'Country'),
      AllowedExport::column('country_code', 'Country Code'),
      AllowedExport::column('fips_code', 'Fips Code'),
      AllowedExport::column('iso2', 'ISO 2'),
      AllowedExport::column('type', 'Type'),
      AllowedExport::column('latitude', 'Latitude'),
      AllowedExport::column('longitude', 'Longitude'),
      AllowedExport::column('flag', 'Flag'),
    ];
  }
}
