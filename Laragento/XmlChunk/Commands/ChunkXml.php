<?php

namespace Laragento\XmlChunk\Commands;

use Illuminate\Console\Command;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Parser\StringWalker;
use Prewk\XmlStringStreamer\Stream\File;

class ChunkXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:chunk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Divide one large XML-File into smaller chunks';

    /**
     * InitialMetaImport constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countFiles = 0;
        do {
            $file = storage_path($this->ask('Which file you want to chunk in storage path (like app/import-export/shop_import/test.xml)?'));
        } while(!file_exists($file));

        do {
        $chunkDirectory = storage_path($this->ask('Where do you want(directory) to save the chunked data in storage path (like app/chunked)?'));
        } while(!is_dir($chunkDirectory));

        do {
            $countEntries = $this->ask('How much items do you want to save in one file (default 1000)?', 1000);
        } while(!is_numeric($countEntries));

        $rootTag = $this->ask('Which is the root tag like "customers" in the XML-File?');

        $totalSize = filesize($file);
        $stream = new File($file, 16384, function($chunk, $readBytes) use ($totalSize) {
            // This closure will be called every time the streamer requests a new chunk of data from the XML file
            echo "Progress: $readBytes / $totalSize\n";
        });
        $parser = new StringWalker();
        $streamer = new XmlStringStreamer($parser, $stream);

        $countItems = 0;
        $fileHandler = $this->createFileHandler($chunkDirectory, $countFiles, $rootTag);

        while ($node = $streamer->getNode()) {

            $countItems++;

            fwrite($fileHandler, $node);

            if($countItems >= $countEntries) {
                $countItems = 0;
                $countFiles++;
                fwrite($fileHandler, "\r\n" . '</' . $rootTag . '>');
                fclose($fileHandler);
                $fileHandler = $this->createFileHandler($chunkDirectory, $countFiles, $rootTag);
            }
        }

        fclose($fileHandler);
    }

    /**
     * @param $chunkDirectory
     * @param $countFiles
     * @param $rootTag
     * @return bool|resource
     */
    private function createFileHandler($chunkDirectory, $countFiles, $rootTag) {
        $fileHandler = fopen($chunkDirectory . '/chunk_' . $countFiles . '.xml', "w");
        fwrite($fileHandler, '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . "\r\n");
        fwrite($fileHandler, '<' . $rootTag . '>');

        return $fileHandler;
    }
}
