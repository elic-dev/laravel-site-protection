<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Passwords For Laravel Site Protection
    |--------------------------------------------------------------------------
    |
    |
    |
    |
    */

    'passwords' => env('SITE_PROTECTION_PASSWORDS'),
    'except_paths' => env('SITE_PROTECTION_EXCEPT_PATHS')

];
