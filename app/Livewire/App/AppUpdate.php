<?php

namespace App\Livewire\App;

use Livewire\Component;;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessBuilderInterface;

class AppUpdate extends Component
{
    use LivewireAlert;

    public string $output = '';
    public bool $isProcessing = false;

    public function runUpdate()
    {
        $this->reset('output');
        $this->isProcessing = true;

        try {
            $outputLines = [];

            $git = new Process(['git', 'pull']);
            $git->setWorkingDirectory(base_path());
            $git->mustRun();
            $outputLines[] = $git->getOutput();
            $composer = new Process(
                ['composer', 'install', '--no-interaction', '--prefer-dist'],
                base_path(),
                ['HOME' => '/tmp']
            );

            // $composer->setWorkingDirectory(base_path());
            $composer->mustRun();
            $outputLines[] = $composer->getOutput();

            $clear = new Process(['php', 'artisan', 'optimize:clear']);
            $clear->setWorkingDirectory(base_path());
            $clear->mustRun();
            $outputLines[] = $clear->getOutput();

            $this->output = implode("\n", $outputLines);

            $this->alert('success', 'Update completed successfully!');
        } catch (ProcessFailedException $e) {
            $this->output = $e->getMessage();
            $this->alert('error', 'Update failed!', [
                'text' => $e->getMessage(),
            ]);
        }

        $this->isProcessing = false;
    }

    public function render()
    {
        return view('livewire.app-update');
    }
}
