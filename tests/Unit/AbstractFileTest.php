<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

abstract class AbstractFileTest extends TestCase
{
    protected function getTempDir(): string
    {
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'tags_manager';
        if (!file_exists($tempDir)) {
            mkdir(directory: $tempDir, recursive: true);
        }

        return $tempDir;
    }

    protected function getTempFile(): string
    {
        $file = $this->getTempDir() . DIRECTORY_SEPARATOR . uniqid('tm_') . '.tf';
        touch($file);

        return $file;
    }

    protected function getSymlink(): string
    {
        $file = $this->getTempFile();
        $symlink = $this->getTempDir() . DIRECTORY_SEPARATOR . uniqid('tm_link_') . '.tf';

        symlink(target: $file, link: $symlink);

        return $symlink;
    }

    protected function cleanFiles(): void
    {
        $files = glob($this->getTempDir() . DIRECTORY_SEPARATOR . '*.tf');

        foreach ($files as $file) {
            if (is_file($file) || is_link($file)) {
                unlink($file);
            }
        }
    }

}
