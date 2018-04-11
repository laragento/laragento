<?php

namespace Laragento\Dev\Fondation\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class PackageMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lg:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Laragento package';

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

        if ($this->option('all')) {
            $this->input->setOption('api', true);
            $this->input->setOption('repository', true);
            $this->input->setOption('transformer', true);
        }

        if ($this->option('api')) {
            $this->createApi();
        }

//            if ($this->option('repository')) {
//                  $this->createRepository();
//            }
//
//            if ($this->option('transformer')) {
//                  $this->createTransformer();
//            }
    }


    /**
     * Create a api in a package.
     *
     * @return void
     */
    protected function createApi()
    {
        $api = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

//            $this->call('make:controller', [
//                  'name' => "{$api}Api",
//                  '--model' => $this->option('resource') ? $modelName : null,
//            ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('api')) {
            return __DIR__ . '/stubs/api.stub';
        }

        if ($this->option('repository')) {
            return __DIR__ . '/stubs/repository.stub';
        }

        if ($this->option('transformer')) {
            return __DIR__ . '/stubs/transformer.stub';
        }

        return false;
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
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a '],

            ['api', 'c', InputOption::VALUE_NONE, 'Create a new '],

            ['repository', 'r', InputOption::VALUE_NONE, 'Create a new '],

            ['transformer', 't', InputOption::VALUE_NONE, 'Create the '],
        ];
    }
}
