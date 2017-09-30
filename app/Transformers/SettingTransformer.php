<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Setting;

class SettingTransformer extends TransformerAbstract
{
    public function transform(Setting $setting) {
        return [
        	'id'   	  => $setting['id'],
            'name'    => $setting['name'],
            'title'   => $setting['title'],
            'value'   => $setting['value'],
        ];
    }
}