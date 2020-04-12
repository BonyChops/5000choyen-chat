<?php

include __DIR__.'/../../vendor/autoload.php';
include __DIR__.'/../config.php';
$accesstoken = $config["discord"]["token"];

use RestCord\DiscordClient;

$discord = new DiscordClient(['token' => $accesstoken]); // Token is required
$discord->on('ready', function ($discord) {
    var_dump($discord->channel->createMessage(['channel.id' => 698789930427482155, 'content' => 'Foo Bar Baz']));
});
