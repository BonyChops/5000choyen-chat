<?php
function Generate($str1, $str2){
    return exec(sprintf('node %s/docs/main.js "%s" "%s"',__DIR__ ,$str1, $str2));
}

function Generate_SPC($price, $username, $comment){
  return exec(sprintf('node %s/docs/SuperChat.js "%s" %s "%s"',__DIR__, $username, $price, $comment));
}

function Generate_SPC_flex($price, $username, $comment = "", $iconURL){
  $preset_money = [100,200,500,1000,2000,5000,8000,9000,10000];
  if ($price == -1){
    $price = $preset_money[rand(0,count($preset_money))];
  }
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
  if($price < 200) $comment = "";
  $price = number_format((int)trim($price));

  $colorcode = preg_replace("/#/", "", $txt_color);
  $array_colorcode["red"] = (int)hexdec(substr($colorcode, 0, 2))*0.7;
  $array_colorcode["green"] = (int)hexdec(substr($colorcode, 2, 2))*0.7;
  $array_colorcode["blue"] = (int)hexdec(substr($colorcode, 4, 2))*0.7;
  $username_color = rgb2hex( [ $array_colorcode["red"], $array_colorcode["green"], $array_colorcode["blue"] ] );
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
                    "size"=> "md",
                    "color"=> $username_color
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
    $comment = "￥".$price." Super Chatを送信しました！";
  }
  return [[
    "type"=> "flex",
    "altText"=> $username.": ".$comment,
    "contents"=> $format
  ]];
}

function avicii($url){
  return [
    "type"=> "bubble",
    "body"=> [
      "type"=> "box",
      "layout"=> "horizontal",
      "contents"=> [
        [
          "type"=> "text",
          "text"=> "◢ ◤",
          "gravity"=> "center",
          "align"=> "center",
          "color"=> "#FFFFFF",
          "size"=> "xxl",
          "action"=> [
            "type"=> "uri",
            "label"=> "action",
            "uri"=> $url
          ]
        ]
      ],
      "backgroundColor"=> "#000000",
      "height"=> "200px",
      "action" => [
        "type"=> "uri",
        "label"=> "action",
        "uri"=> $url
      ]
    ]
];
}

function Generate_tex($text, $mc = false){
  $command = $text;
  $header = '\documentclass[a4j, titlepage, dvipdfmx]{jarticle}
  \usepackage{float}
  \usepackage[dvipdfmx]{graphicx}
  %\usepackage{mediabb}
  \makeatletter
  %https://qiita.com/ta_b0_/items/2619d5927492edbb5b03
  \usepackage{listings,jlisting} %日本語のコメントアウトをする場合jlstlistingが必要
  %ここからソースコードの表示に関する設定
  \lstset{
    basicstyle={\ttfamily},
    identifierstyle={\small},
    commentstyle={\smallitshape},
    keywordstyle={\small\bfseries},
    ndkeywordstyle={\small},
    stringstyle={\small\ttfamily},
    frame={tb},
    breaklines=true,
    columns=[l]{fullflexible},
    numbers=left,
    xrightmargin=0zw,
    xleftmargin=3zw,
    numberstyle={\scriptsize},
    stepnumber=1,
    numbersep=1zw,
    lineskip=-0.5ex
  }
  %ここまでソースコードの表示に関する設定
  \pagestyle{empty} % すべてのページ番号を消去
  \def\tightlist{\itemsep1pt\parskip0pt\parsep0pt}
  \usepackage{pdfpages}
  \usepackage{amssymb}
  \usepackage{amsmath}
  \usepackage{okumacro}
  \usepackage{url}
  \begin{document}
  ';
  $footer = '
  \end{document}';
  $header_md = "\pagenumbering{gobble}\n\n";
  if($mc){
    file_put_contents(__DIR__.'/tmp.md', $header_md.trim($command));
    exec('timeout 15 pandoc '.__DIR__.'/tmp.md -o '.__DIR__.'/tmp.pdf --pdf-engine=lualatex -V documentclass=ltjarticle',$array,$return);
    //copy(__DIR__.'/tmp.pdf',__DIR__.'/check.pdf');
    unlink(__DIR__.'/tmp.md');
    if (!$return) {
      echo 'good';
      generateImg();
      return TRUE;
    }else{
      return FALSE;
    }
  }
  if(file_exists(__DIR__."/tmp.tex")) unlink(__DIR__."/tmp.tex");
  file_put_contents(__DIR__."/tmp.tex", $header.$command.$footer);
  if (exec('cd '.__DIR__.' && timeout 10 ptex2pdf -ot -interaction="nonstopmode" -l tmp.tex 2> error.log',$array)) {
    generateImg();
    return TRUE;
  }else{
    return FALSE;
  }
}
function generateImg(){
  exec('cd '.__DIR__.' && pdftoppm -r 300 -l 1 -png '.__DIR__.'/tmp.pdf image && convert input '.__DIR__.'/image-1.png -trim '.__DIR__.'/result.png');
  foreach (glob(__DIR__.'/tmp*') as$val ) {
    unlink($val);
  }
  unlink(__DIR__.'/image-1.png');
}

function Generate_gnuplot($text, $sameRate = false){
  $command = $text;
  file_put_contents(__DIR__."/tmp.dat", $command);
  $settings = 'set terminal png
set output "result-gnuplot.png"
plot "tmp.dat" with lines notitle';
if($sameRate) $settings."\nset size ratio -1";
  file_put_contents(__DIR__."/tmp.gnuplot", $settings);
  exec('cd '.__DIR__.' && timeout 10  gnuplot "tmp.gnuplot"',$array,$result);
  foreach (glob(__DIR__.'/tmp*') as$val ) {
    unlink($val);
  }
  if ((!$result)&&file_exists(__DIR__.'/result-gnuplot.png')&&(file_get_contents(__DIR__.'/result-gnuplot.png') != "")) {
    return TRUE;
  }else{
    return FALSE;
  }
}

function rgb2hex ( $rgb ) {
	return "#" . implode( "", array_map( function( $value ) {
		return substr( "0" . dechex( $value ), -2 ) ;
	}, $rgb ) ) ;
}



?>