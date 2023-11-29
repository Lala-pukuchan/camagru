<?php
// Cloudinary configuration settings
return [
    'cloud' => [
        'cloud_name' => getenv('CLOUDINARY_CLOUD_NAME'), 
        'api_key' => getenv('CLOUDINARY_API_KEY'), 
        'api_secret' => getenv('CLOUDINARY_API_SECRET')
    ],
    'url' => [
        'secure' => true
    ]
];
?>