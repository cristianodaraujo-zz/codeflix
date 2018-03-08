<?php

namespace App\Media;

use Illuminate\Filesystem\FilesystemAdapter;

trait VideoStorageTrait
{
    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage()
    {
        return \Storage::disk($this->getDriver());
    }

    protected function getDriver()
    {
        return config('filesystems.default');
    }

    protected function getRootPath(FilesystemAdapter $adapter, $name)
    {
        return $this->isLocalDriver()
            ? $adapter->getDriver()->getAdapter()->applyPathPrefix($name)
            : $adapter->url($name);
    }

    protected function isLocalDriver()
    {
        return config("filesystems.disks.{$this->getDriver()}.driver") == 'local';
    }
}