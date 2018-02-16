<?php

namespace Laragento\XmlChunk;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class XmlChunkServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Laragento\XmlChunk\Commands\ChunkXml',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
