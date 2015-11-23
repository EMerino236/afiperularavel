<?php
return array(
    // set your paypal credential
    'client_id' => 'ASmHc1Vntg-KyLxUlgsEsL3JeH15Ih34zTHbhLocc9tyssXxCxCoXAph__kkoCPVcuuAUF-x4dwkRpom',
    'secret' => 'EHTwkXvxlO9swAgZkVUsE3WeDBnkDYImr7dxPsNUkrnYW4uUUQXjFyHTtfMbyr0bTLL89RbaUPWil1qT',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);