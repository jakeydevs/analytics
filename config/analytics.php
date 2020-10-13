<?php

return [

    /**
     * Where is our Maxmind database so we can parse locations
     *
     */
    'maxmind_db' => base_path('database/maxmind/db.mmdb'),

    /**
     * Maximum time on a page
     */
    'max_time_spent_on_page' => 3600,

    /**
     * GDPR
     * Once we have saved our row, delete these columns from the
     * database
     */
    'delete_senstive' => [
        'user_agent',
        'ip',
    ],
];
