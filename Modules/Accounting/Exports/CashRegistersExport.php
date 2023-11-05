<?php

namespace Modules\Accounting\Exports;

use App\Exports\AllowedExport;
use App\Exports\QueryExport;
use App\Repositories\BaseRepository;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Accounting\Repositories\CashRegisterRepository;

class CashRegistersExport extends QueryExport implements WithHeadings
{
  public function repository(): BaseRepository
  {
    return app(CashRegisterRepository::class);
  }

  public function allowedExports(): array
  {
    return [
      AllowedExport::column('id', 'ID'),
      AllowedExport::column('name', 'Name'),
      AllowedExport::column('rtl_name', 'RTL Name'),
      AllowedExport::column('status', 'Status'),
      AllowedExport::column('initial_balance', 'Initial Balance'),

      AllowedExport::morphTo('owner', 'Owner', [
        \App\Models\School::class => 'school',
        \Modules\Education\Entities\Student::class => 'student',
        \Modules\Education\Entities\Guardian::class => 'guardian',
        \Modules\Education\Entities\Staff::class => 'staff',
      ]),
    ];
  }
}
