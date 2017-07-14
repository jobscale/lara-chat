<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use App\Channel;

class ChannelRepository extends Repository
{

    private $model;

    function __construct(Channel $model)
    {
        $this->model = $model;
    }

    function store($data)
    {
        Log::info('request', ['data' => json_encode($data)]);
        $item = $this->model
            ->where('name', $data->name)
            ->first();
        if (!$item) {
            $item = new Channel;
        }
        $this->set($item, $data);
        $item->save();
    }

}
