#!/bin/bash -eu

sudo chmod -R ug+rwX storage bootstrap/cache
sudo chown -R $(id -un):www-data storage bootstrap/cache

