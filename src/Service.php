<?php

namespace qiaode\filesystem;

class Service extends \think\Service {
    public function register()    {
        $this->app->bind('filesystem', Filesystem::class);
    }
}
