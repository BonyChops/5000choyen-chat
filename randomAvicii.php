<?php
    $urls = [
        'https://www.youtube.com/watch?v=IcrbM1l_BoI',
        'https://www.youtube.com/watch?v=cHHLHGNpCSA',
        'https://www.youtube.com/watch?v=UtF6Jej8yb4',
        'https://www.youtube.com/watch?v=YxIiPLVR6NA',
        'https://www.youtube.com/watch?v=_ovdm2yX4MA',
        'https://www.youtube.com/watch?v=5y_KJAg8bHI',
        'https://www.youtube.com/watch?v=JDglMK9sgIQ',
        'https://www.youtube.com/watch?v=6Cp6mKbRTQY',
        'https://www.youtube.com/watch?v=-ncIVUXZla8',
    ];
    header('location: '.$urls[rand(0, count($urls))]);