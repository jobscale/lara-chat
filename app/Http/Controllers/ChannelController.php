<?php

namespace App\Http\Controllers;

use App\Repositories\ChannelRepository;
use App\Http\Requests\StoreChannelRequest;

class ChannelController extends Controller
{
    private $channel;

    function __construct(ChannelRepository $channel)
    {
        $this->channel = $channel;
    }

    function store(StoreChannelRequest $request) {
        $input = (object)$request->all();
        $input->ip = $request->server('REMOTE_ADDR');
        $this->channel->store($input);
        return redirect("/");
    }
}
