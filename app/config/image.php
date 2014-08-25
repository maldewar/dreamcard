<?php

return array(
    'library'     => 'imagick',
    'upload_dir'  => 'uploads',
    'upload_path' => public_path() . '/uploads/',
    'quality'     => 85,
    'dimensions' => array(
      'small_thumb' => array(50, 50, true, 75),
      'thumb'  => array(100, 100, true,  80),
      'medium' => array(300, 200, true, 90),
    ),
);
