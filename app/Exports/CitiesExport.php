<?php

namespace App\Exports;
use App\Repositories\BaseRepository;
use App\Repositories\CityRepository;

class CitiesExport extends QueryExport
{
  public function repository(): BaseRepository
  {
    return app(CityRepository::class);
  }

  public function allowedExports(): array
  {
    return [
      AllowedExport::column('id', 'ID'),
      AllowedExport::column('name', 'Name'),
      AllowedExport::belongsTo('country', 'Country'),
      AllowedExport::column('country_code', 'Country Code'),
      AllowedExport::belongsTo('state', 'State'),
      AllowedExport::column('state_code', 'State Code'),
      AllowedExport::column('latitude', 'Latitude'),
      AllowedExport::column('longitude', 'Longitude'),
      AllowedExport::column('flag', 'Flag'),
    ];
  }
}
