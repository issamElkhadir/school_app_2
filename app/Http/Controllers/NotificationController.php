<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  protected NotificationRepository $repository;

  public function __construct(NotificationRepository $repository)
  {
    $this->repository = $repository;

    $this->repository->whereMorphedTo('notifiable', auth()->user());
  }

  public function index(Request $request)
  {
    return NotificationResource::collection(
      $this->paginate($request, $this->repository)
    );
  }

  public function read(Notification $notification)
  {
    $this->repository->read($notification);

    return response()->noContent();
  }

  public function readAll()
  {
    $this->repository->readAll();

    return response()->noContent();
  }

  public function destroy(Notification $notification)
  {
    $notification->delete();

    return response()->noContent();
  }
}
