<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\Notification;
use App\Notifications\NotificationAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedExport implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * The name of the file.
   *
   * @var string
   */
  private string $filename;

  /**
   * The user instance to notify.
   *
   * @var User
   */
  private User $user;

  /**
   * Create a new job instance.
   */
  public function __construct(User $user, string $filename)
  {
    $this->user = $user;
    $this->filename = $filename;
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    $this->user->notify(
      Notification::make()
        ->title('Export Completed')
        ->body('Your export has completed.')
        ->success()
        ->icon('tblr.IconFile')
        ->actions([
          NotificationAction::make('Download')
            ->icon('tblr.IconDownload')
            ->color('success')
            ->button()
            ->markAsRead()
            ->openInNewTab()
            ->url(route('download', [
              'filename' => $this->filename,
            ])),
        ])
    );
  }
}
