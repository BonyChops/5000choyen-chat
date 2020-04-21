<?php
function Generate($str1, $str2){
    return exec(sprintf('node %s/docs/main.js "%s" "%s"',__DIR__ ,$str1, $str2));
}

function Generate_SPC($price, $username, $comment){
    return exec(sprintf('node %s/docs/SuperChat.js "%s" %s "%s"',__DIR__, $price, $username, $comment));
}
/*
{
  "type": "bubble",
  "header": {
    "type": "box",
    "layout": "horizontal",
    "contents": [
      {
        "type": "box",
        "layout": "baseline",
        "contents": [
          {
            "type": "icon",
            "url": "https://profile.line-scdn.net/0h-ikgVjVockZWHlnKtGENEWpbfCshMHQOLns0JntLeH96fDdEbSxuJHZOLHBzK2JHaX1vKCceJHF-",
            "size": "4xl"
          }
        ],
        "width": "70px"
      },
      {
        "type": "box",
        "layout": "baseline",
        "contents": [
          {
            "type": "text",
            "wrap": true,
            "contents": [
              {
                "type": "span",
                "text": "Bony_Chops\n",
                "size": "md"
              },
              {
                "type": "span",
                "text": "￥500",
                "size": "3xl"
              }
            ],
            "text": "Bony_Chops"
          }
        ]
      }
    ]
  },
  "body": {
    "type": "box",
    "layout": "horizontal",
    "contents": [
      {
        "type": "text",
        "text": "LINE flex Messageで作ったスパチャ風のそれ",
        "wrap": true
      }
    ]
  },
  "styles": {
    "header": {
      "backgroundColor": "#00bfa5"
    },
    "body": {
      "backgroundColor": "#1de9b6"
    }
  }
}
*/
?>