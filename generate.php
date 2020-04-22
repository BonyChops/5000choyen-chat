<?php
function Generate($str1, $str2){
    return exec(sprintf('node %s/docs/main.js "%s" "%s"',__DIR__ ,$str1, $str2));
}

function Generate_SPC($price, $username, $comment){
  return exec(sprintf('node %s/docs/SuperChat.js "%s" %s "%s"',__DIR__, $username, $price, $comment));
}

function Generate_SPC_flex($price, $username, $comment = "", $iconURL){
  $colors      = ["#134a9e","#00b8d4","#00bfa5","#ffb300","#e65100","#c2185b","#d00000"];
  $base_colors = ["#134a9e","#00e5ff","#1de9b6","#ffca28","#f57c00","#e91e63","#e62117"];
  $txt_colors  = ["#FFFFFF","#000000","#000000","#000000","#000000","#FFFFFF","#FFFFFF"];
  $n = [200,500,1000,2000,5000,10000];
  for ($i = 0; $i < count($n); $i++) {
    if($n[$i] > $price){
      $color = $colors[$i];
      $base_color = $base_colors[$i];
      $txt_color = $txt_colors[$i];
      break;
    }
  }
  if($color == null){
    $color = $colors[count($n)];
    $base_color = $base_colors[count($n)];
    $txt_color = $txt_colors[count($n)];
  }
  $price = number_format((int)trim($price));
  if ($comment != ""){
    $format = [
      "type"=> "bubble",
      "header"=> [
        "type"=> "box",
        "layout"=> "horizontal",
        "contents"=> [
          [
            "type"=> "box",
            "layout"=> "baseline",
            "contents"=> [
              [
                "type"=> "icon",
                "url"=> $iconURL,
                "size"=> "4xl"
              ]
            ],
            "width"=> "70px"
          ],
          [
            "type"=> "box",
            "layout"=> "baseline",
            "contents"=> [
              [
                "type"=> "text",
                "wrap"=> true,
                "contents"=> [
                  [
                    "type"=> "span",
                    "text"=> $username."\n",
                    "size"=> "md"
                  ],
                  [
                    "type"=> "span",
                    "text"=> "￥".$price,
                    "size"=> "3xl",
                    "color"=> $txt_color
                  ]
                ],
                "text"=> $username
              ]
            ]
          ]
        ]
      ],
      "body"=> [
        "type"=> "box",
        "layout"=> "horizontal",
        "contents"=> [
          [
            "type"=> "text",
            "text"=> $comment,
            "wrap"=> true,
            "color"=> $txt_color
          ]
        ]
      ],
      "styles"=> [
        "header"=> [
          "backgroundColor"=> $color
        ],
        "body"=> [
          "backgroundColor"=> $base_color
        ]
      ]
    ];
  }else{
    $format = [
      "type"=> "bubble",
      "header"=> [
        "type"=> "box",
        "layout"=> "horizontal",
        "contents"=> [
          [
            "type"=> "box",
            "layout"=> "baseline",
            "contents"=> [
              [
                "type"=> "icon",
                "url"=> $iconURL,
                "size"=> "4xl"
              ]
            ],
            "width"=> "70px"
          ],
          [
            "type"=> "box",
            "layout"=> "baseline",
            "contents"=> [
              [
                "type"=> "text",
                "wrap"=> true,
                "contents"=> [
                  [
                    "type"=> "span",
                    "text"=> $username."\n",
                    "size"=> "md"
                  ],
                  [
                    "type"=> "span",
                    "text"=> "￥".$price,
                    "size"=> "3xl",
                    "color"=> $txt_color
                  ]
                ],
                "text"=> $username
              ]
            ]
          ]
        ]
      ],
      "styles"=> [
        "header"=> [
          "backgroundColor"=> $color
        ],
        "body"=> [
          "backgroundColor"=> $base_color
        ]
      ]
    ];
  }
  if($comment == ""){
    $comment = "￥".$price."Super Chatを送信しました！";
  }
  return [[
    "type"=> "flex",
    "altText"=> $username.": ".$comment,
    "contents"=> $format
  ]];
}



?>