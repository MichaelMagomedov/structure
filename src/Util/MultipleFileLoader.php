<?php

namespace Structure\Util;

use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;

/**
 * Class MultipleFileLoader
 */
class MultipleFileLoader extends FileLoader
{

    /**
     * MultipleFileLoader constructor.
     * @param Filesystem $files
     * @param $paths
     */
    public function __construct(Filesystem $files, $paths)
    {
        $this->path = (array)$paths;
        $this->files = $files;
    }

    /**
     * @param $relativePaths
     * @param string $locale
     * @param string $group
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function loadPath($paths, $locale, $group)
    {
        $group = mb_strtolower($group);
        if (!isset($paths[$group])) {
            return [];
        }
        $translations = [];
        $path = $paths[$group];
        if ($this->files->exists($full = "$path/$locale.php")) {
            $translations = $this->files->getRequire($full);
        }
        return $translations;
    }
}