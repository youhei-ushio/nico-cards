<?php

return [
    'room' => [
        'index' => [
            'title' => '待合室',
            'member_count' => ':count 名',
            'enter' => '入室',
            'full' => '満員',
            'leave' => '退室',
        ],
        'entered_self' => ':room に入室しました。',
        'entered' => ':name が入室しました。',
        'left_self' => ':room から退室しました。',
        'left' => ':name が退室しました。',
        'room_is_full' => ':name は満員のため入室できません。',
        'room_is_playing' => ':name は対戦中のため入室できません。',
        'leave_first' => '先に部屋から退室してください。',
        'cannot_leave_round' => 'ゲーム中は退室できません。',
    ],
];
