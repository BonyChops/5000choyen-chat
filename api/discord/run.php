<?php

include __DIR__.'/../../vendor/autoload.php';
include __DIR__.'/../config.php';
$accesstoken = $config["discord"]["token"];

use RestCord\DiscordClient;

$discord = new DiscordClient(['token' => $accesstoken]); // Token is required

var_dump($discord->channel->createMessage(['channel.id' => 698789930427482155, 'content' => 'Foo Bar Baz']));
var_dump(
    $client->channel->createMessage([
         'channel.id' => $channelId,
         'content'    => "this `supports` __a__ **subset** *of* ~~markdown~~ 😃 ```js
 function foo(bar) {
   console.log(bar);
 }
 
 foo(1);```",
         'embed'      => [
             "title" => "title ~~(did you know you can have markdown here too?)~~",
             "description" => "this supports [named links](https://discordapp.com) on top of the previously shown subset of markdown. ```\nyes, even code blocks```",
             "url" => "https://discordapp.com",
             "color" => 14290439,
             "timestamp" => "2017-02-20T18:05:58.512Z",
             "footer" => [
                 "icon_url" => "https://cdn.discordapp.com/embed/avatars/0.png",
                 "text" => "footer text"
             ],
             "thumbnail" => [
                 "url" => "https://cdn.discordapp.com/embed/avatars/0.png"
             ],
             "image" => [
                 "url" => "https://cdn.discordapp.com/embed/avatars/0.png"
             ],
             "author" => [
                 "name" => "author name",
                 "url" => "https://discordapp.com",
                 "icon_url" => "https://cdn.discordapp.com/embed/avatars/0.png"
             ],
             "fields" => [
                 [
                     "name" => "Foo",
                     "value" => "some of these properties have certain limits..."
                 ],
                 [
                     "name" => "Bar",
                     "value" => "try exceeding some of them!"
                 ],
                 [
                     "name" => " 😃",
                     "value" => "an informative error should show up, and this view will remain as-is until all issues are fixed"
                 ],
                 [
                     "name" => "<:thonkang:219069250692841473>",
                     "value" => "???"
                 ]
             ]
         ]
     ])
 );