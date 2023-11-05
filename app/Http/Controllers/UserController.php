<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Language;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
  protected UserRepository $repository;

  public function __construct(UserRepository $repository)
  {
    $this->repository = $repository;

    $this->middleware('permission:base.user.store')->only('store');
    $this->middleware('permission:base.user.update')->only('update');
    $this->middleware('permission:base.user.destroy')->only('destroy');
    $this->middleware('permission:base.user.index')->only('index');
    $this->middleware('permission:base.user.show')->only('show');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    return UserResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(UserRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UserRequest $request, User $user)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $user->delete();

    return response()->json([
      'message' => 'User deleted successfully',
    ]);
  }

  /**
   * Set the user's theme.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function setTheme(Request $request)
  {
    $request->user()->update([
      'theme' => $request->input('theme'),
    ]);

    return response()->json([
      'message' => 'Theme updated successfully',
    ]);
  }

  /**
   * Set the user's locale.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function setLocale(Request $request)
  {
    $request->validate([
      'iso' => 'required|exists:languages,iso_code'
    ]);

    /** @var Language $language */
    $language = Language::query()
      ->where('iso_code', '=', $request->input('iso'))
      ->first();

    $request->user()->language()->associate($language)->save();

    // Switch the app locale
    app()->setLocale($language->iso_code);

    return response()->json([
      'message' => 'Locale updated successfully',
    ]);
  }
}
