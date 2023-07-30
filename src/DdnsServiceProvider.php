<?php

namespace itinysun\ddns;

use Slowlyo\OwlAdmin\Renderers\TextControl;
use Slowlyo\OwlAdmin\Extend\ServiceProvider;

class DdnsServiceProvider extends ServiceProvider
{

    public $menu = [
        [
            'title' => 'DDNS',
            'url' => '/ddns',
            'icon' => 'teenyicons:terminal-outline',
        ]
    ];

    public function settingForm()
    {
        return $this->baseSettingForm()->body([

        ]);
    }
}
