<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtisanCommandRunner extends Controller
{
  private const CACHE_PREFIX = 'vite-server-';

  public function __invoke(Request $request)
  {
    // Find the user running the client process
    $user = $this->getProcessUser($request);

    $group = 'melbahja'; // Should be www-data on Linux

    // If the user is null, return an error
    if (is_null($user)) {
      return response()->json([
        'output' => 'Unable to determine the user running the process.',
      ]);
    }

    $request->validate([
      'command' => 'required|string',
    ]);

    $command = escapeshellcmd($request->input('command'));

    $path = base_path();

    $command = match (php_uname('s')) {
      'Linux' => "su - $user -pg $group -c \"umask 0166 && cd $path && php artisan $command\" --ansi",
      'Windows NT' => "cd $path && php artisan $command --ansi",
    };

    $output = shell_exec($command);

    // if (is_string($output)) {
    //   $output = trim($output);
    // }

    // Log the user, datetime, command
    \Log::channel('route-command')
      ->info("User $user ran command php artisan $request->command at " . now()->toDateTimeString() . ".", [
        'user' => $user,
        'command' => 'php artisan ' . $request->command,
        'datetime' => now()->toDateTimeString(),
        'ip' => $request->ip(),
        'output' => $this->ansi2text($output),
      ]);

    return response()->json([
      'output' => $output,
    ]);
  }

  private function ansi2text(string $ansi): string
  {
    $ansi = preg_replace('/\e\[[\d;]*m/', '', $ansi);

    return $ansi;
  }

  private function getProcessUser(Request $request): null|string
  {
    $host = $request->header('origin');

    // Get the port from the host
    $port = parse_url($host, PHP_URL_PORT);

    if ($port === null) {
      return null;
    }

    // Find the process id running in $port
    $command = match (php_uname('s')) {
      'Linux' => "lsof -i:$port -P -t -sTCP:LISTEN",
      'Windows NT' => "netstat -ano | findstr :$port | findstr LISTENING | awk '{print $5}'",
    };

    $pid = shell_exec($command);

    if (is_string($pid)) {
      $pid = trim($pid);
    }

    // Find the user running the process
    $command = match (php_uname('s')) {
      'Linux' => "ps -o user= -p $pid",
      'Windows NT' => "tasklist /v /FI \"PID eq $pid\" | findstr /I /C:\"$pid\" | awk '{print $8}'",
    };

    $user = shell_exec($command);

    if (is_string($user)) {
      $user = trim($user);

      $user = \Str::afterLast($user, '\\');
    }

    return $user;
  }

  public function serve(Request $request)
  {
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);


    $username = $request->input('username');
    $password = $request->input('password');

    // Check if the linux user exists
    $command = "id -u $username";

    $output = shell_exec($command);

    if (is_string($output)) {
      $output = trim($output);
    }

    $cacheKey = self::CACHE_PREFIX . "$username";

    $port = cache()->get($cacheKey);



    if (is_null($port)) {

    } else {
      // Check server status
      $command = "lsof -i:$port -P -t -sTCP:LISTEN";

      $output = shell_exec($command);

      if (is_string($output)) {
        $output = trim($output);
      }

      if (empty($output)) {
        // Start the server
        $this->startServer($username, $password);
      }
    }
  }

  public function check(Request $request)
  {

  }

  private function startServer(string $username, string $password)
  {
    $cacheKey = self::CACHE_PREFIX . "$username";

    $clientPath = base_path() . '../frontend';

    $command = "cd $clientPath && npm run dev";

    $output = shell_exec($command);

    if (is_string($output)) {
      $output = trim($output);
    }
  }
}
