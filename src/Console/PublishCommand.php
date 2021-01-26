<?php

namespace ActiveGenerator\JetstreamToolbox\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishCommand extends Command
{
    protected $signature = 'toolbox:publish {tag : views, traits, or all} {--force : Override existing files}';
    protected $description = 'Publish the toolbox for customization';

    public function handle()
    {
        $tag = $this->argument('tag');
        $force = $this->option('force');

        Artisan::call('vendor:publish', [
          '--tag' => $tag,
          '--force' => $force,
          '--provider' => 'ActiveGenerator\JetstreamToolbox\JetstreamToolboxServiceProvider'
        ], $this->getOutput());
    }
}
