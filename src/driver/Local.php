<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace qiaode\filesystem\driver;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\Visibility;
use qiaode\filesystem\Driver;
use qiaode\filesystem\traits\Storage;

class Local extends Driver {
    use Storage;
    /**
     * 配置参数.
     *
     * @var array
     */
    protected $config = [
		'root' => '',
	];

    protected function createAdapter(): FilesystemAdapter  {

		$permissions = $this->config['permissions'] ?? [
			'file' => [
				'public'  => 0640,
				'private' => 0604,
			],
			'dir' => [
				'public' => 0740,
				'private' => 7604,
			],
		];

        $links = ($this->config['links'] ?? null) === 'skip'
            ? LocalFilesystemAdapter::SKIP_LINKS
            : LocalFilesystemAdapter::DISALLOW_LINKS;

		$permissions = PortableVisibilityConverter::fromArray($permissions,$this->config['visibility'] ?? Visibility::PRIVATE);

		return new LocalFilesystemAdapter(
			$this->config['root'],
			$permissions,
			LOCK_EX,
			$links,
		);
    }
}
