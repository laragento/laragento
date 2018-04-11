<?php

namespace Laragento\Dev\Fondation\Console;

use Illuminate\Console\GeneratorCommand;

class ApiMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lg:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Laragento api class';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return;
        }

    }


    /**
     * Create a api in a package.
     *
     * @return void
     */
    protected function createApi()
    {

    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {

    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {

    }
}
