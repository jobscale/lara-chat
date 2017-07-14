<?php

namespace App\Repositories;

class Repository
{

    function set($item, $data)
    {
        foreach ($data as $key => $value) {
            if ($key === '_token' ||
                preg_match('/_confirmation$/', $key)) {
                continue;
            }
            if ($key === 'ip') {
                $value = encrypt($value);
            }
            if ($key === 'password') {
                $value = bcrypt($value);
            }
            $item->{$key} = $value;
        }
    }

}
