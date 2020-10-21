<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Location database
    |--------------------------------------------------------------------------
    |
    | The location below should have the GeoLite-Country database inside it
    | and accessable
    |
     */
    'maxmind_db' => base_path('database/maxmind/db.mmdb'),

    /*
    |--------------------------------------------------------------------------
    | Delete sensitive data
    |--------------------------------------------------------------------------
    |
    | The system will remove these senstive columns once the row has been
    | processed.
    |
     */
    'delete_senstive' => [
        'user_agent',
        'ip',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum time on a page
    |--------------------------------------------------------------------------
    |
    | If the previous page view for this user is over this amount, we'll mark
    | the page view as being bounced
    |
     */
    'max_time_spent_on_page' => 3600,

    /*
    |--------------------------------------------------------------------------
    | Data parsing
    |--------------------------------------------------------------------------
    |
    | When should we parse the data?
    |
    | Getting the users location can be a slow process, so we advise to either
    | use the "queue" or "cron" options rather than the "request" option which
    | processes the data on the request.
    |
    | If you use the "cron" option, please add a scheduled job to
    | \Jakeydevs\Analytics\Actions\Schedule::collate() every few minutes!
    |
    | If you use the "queue" option, you can set the queue that the job
    | will be dispatched on
    |
    | Supported: "cron", "queue", "request"
     */
    'parse' => 'request',
    'parse_queue' => 'default',

];
