<?php
$keyUsageCsv = null;
if (isset($keyUsage)) {
    $todayString = date('Y-m-d');
    $today = strtotime($todayString);
    $startDate = key($keyUsage); // oldest date for sparkline
    $startDate = strtotime($startDate) - (3600 * 24 * 3);
    $keyUsageCsv = 'Date,Close\n';
    for ($date = $startDate; $date <= $today; $date += (3600 * 24)) {
        $dateAsString = date('Y-m-d', $date);
        $keyUsageCsv .= $dateAsString . ',' . (isset($keyUsage[$dateAsString]) ? $keyUsage[$dateAsString] : 0) . '\n';
    }
}

echo $this->element(
    'genericElements/SingleViews/single_view',
    [
        'title' => 'Auth key view',
        'data' => $data,
        'fields' => [
            [
                'key' => __('ID'),
                'path' => 'AuthKey.id'
            ],
            [
                'key' => __('UUID'),
                'path' => 'AuthKey.uuid',
            ],
            [
                'key' => __('Auth Key'),
                'path' => 'AuthKey',
                'type' => 'authkey'
            ],
            [
                'key' => __('User'),
                'path' => 'User.id',
                'pathName' => 'User.email',
                'model' => 'users',
                'type' => 'model'
            ],
            [
                'key' => __('Comment'),
                'path' => 'AuthKey.comment'
            ],
            [
                'key' => __('Created'),
                'path' => 'AuthKey.created',
                'type' => 'datetime'
            ],
            [
                'key' => __('Expiration'),
                'path' => 'AuthKey.expiration',
                'type' => 'expiration'
            ],
            [
                'key' => __('Key usage'),
                'type' => 'sparkline',
                'path' => 'AuthKey.id',
                'csv' => [
                    'data' => $keyUsageCsv,
                ],
                'requirement' => isset($keyUsage),
            ],
            [
                'key' => __('Last used'),
                'raw' => $lastUsed ? date('Y-m-d H:i:s', $lastUsed) : __('Not used yet'),
                'requirement' => isset($keyUsage),
            ],
            [
                'key' => __('Unique IPs'),
                'raw' => $uniqueIps,
                'requirement' => isset($keyUsage),
            ]
        ],
    ]
);
