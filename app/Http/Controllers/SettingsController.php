<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Resources\SettingsResource;
use App\Repositories\SettingsRepository;

class SettingsController extends Controller
{
  protected SettingsRepository $repository;

  public function __construct(SettingsRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \App\Http\Resources\SettingsResource
   */
  public function index()
  {
    $availableSettings = config('settings.settings');

    return SettingsResource::make($availableSettings);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \App\Http\Requests\UpdateSettingsRequest $request
   * @return \App\Http\Resources\SettingsResource
   */
  public function update(UpdateSettingsRequest $request)
  {
    $availableSettings = config('settings.settings');

    foreach ($availableSettings as $class) {
      /** @var \Spatie\LaravelSettings\Settings */
      $settings = app($class);

      $this->repository->update($settings, $request->input($settings->group(), []));
    }

    return SettingsResource::make($availableSettings);
  }
}
