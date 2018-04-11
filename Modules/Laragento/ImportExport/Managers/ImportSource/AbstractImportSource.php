<?php


namespace Laragento\ImportExport\Managers\ImportSource;


use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class AbstractImportSource implements ImportSourceInterface
{

    protected $messages;

    protected $subsets = [];

    protected $config = [
        ImportSourceInterface::CONFIG_IMPORT_DRIVER => 'local',
        ImportSourceInterface::CONFIG_IMPORTFILES_SOURCEPATH => '',
        ImportSourceInterface::CONFIG_IMPORTFILES_TARGETPATH => '',
        ImportSourceInterface::CONFIG_IMPORT_FORMATS => [],
    ];

    public function import($config = false)
    {
        $this->configure($config);
        $this->execute();
        return $this->messages;
    }

    /**
     * @param $sourcePath
     */
    public function setSourcePath($sourcePath)
    {
        $this->config[ImportSourceInterface::CONFIG_IMPORTFILES_SOURCEPATH] = $sourcePath;
    }

    public function getSourcePath()
    {
        //dd($this->config[ImportSourceInterface::CONFIG_IMPORTFILES_SOURCEPATH]);
        //dd(realpath(base_path() . '/' . $this->config[ImportSourceInterface::CONFIG_IMPORTFILES_SOURCEPATH]));
        return realpath(base_path() . '/' . $this->config[ImportSourceInterface::CONFIG_IMPORTFILES_SOURCEPATH]);
    }

    public function subsetPath(string $path, $subset)
    {
        if ($subset !== null) {
            $subset = $subset . '/';
        }
        return $path . '/' . $subset;
    }

    /**
     * @param $targetPath
     */
    public function setTargetPath($targetPath)
    {
        $this->config[ImportSourceInterface::CONFIG_IMPORTFILES_TARGETPATH] = $targetPath;
    }

    public function getTargetPath()
    {
        $path = storage_path() . '/' . $this->config[ImportSourceInterface::CONFIG_IMPORTFILES_TARGETPATH];

        return $path;
    }


    public function configure($config)
    {
        if ($config) {
            $this->config($config);
        }

    }

    public function execute()
    {
        try {
            if (empty($this->subsets)) {
                if (!File::exists($this->getTargetPath())) {
                    File::makeDirectory($this->getTargetPath(), self::MODE, true);
                }
                $files = File::files($this->getSourcePath());
                $this->importFiles($files);
            } else {
                foreach ($this->subsets as $subset) {
                    if (!File::exists($this->subsetPath($this->getTargetPath(),$subset))) {
                        File::makeDirectory($this->subsetPath($this->getTargetPath(),$subset), self::MODE, true);
                    }
                    $files = File::files($this->subsetPath($this->getSourcePath(),$subset));
                    $this->importFiles($files, $subset);
                }
            }
        } catch (\ErrorException $exception) {
            print_r($exception->getMessage());

        }

    }

    /**
     * @param $newConfig
     * @todo replace with array function
     */
    public function config($newConfig)
    {
        if ($newConfig) {
            foreach ($this->config as $configKey => $configEntry) {
                if (isset($newConfig[$configKey])) {
                    $this->config[$configKey] = $newConfig[$configKey];
                }
            }
        }
    }

    public function importFiles($files, $subset = null)
    {

        foreach ($files as $file) {
            if ($this->importAllFormats() || $this->validImportFile($file) ) {
                $fileName = $file->getFilename();
                File::move($this->subsetPath($this->getSourcePath(),$subset) . $fileName, $this->subsetPath($this->getTargetPath(),$subset) . $fileName);
                $fileName = null;

            }
        }
    }

    /**
     * @return bool
     */
    private function importAllFormats()
    {
        return empty($this->config[ImportSourceInterface::CONFIG_IMPORT_FORMATS]);
    }

    /**
     * @param Finder $file
     * @return bool
     */
    private function validImportFile($file)
    {
        return in_array($file->getExtension(), $this->config[ImportSourceInterface::CONFIG_IMPORT_FORMATS]);
    }
}