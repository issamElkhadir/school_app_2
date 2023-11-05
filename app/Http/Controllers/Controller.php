<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  public function paginate(Request $request, BaseRepository $repository)
  {
    $perPage = $request->input(config('platform.paginator.per_page'), null);

    return $repository->paginate($perPage);
  }
}
