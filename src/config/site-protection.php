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
    'skip_environments' => env('SITE_PROTECTION_SKIP_ENVIRONMENTS', []),

];