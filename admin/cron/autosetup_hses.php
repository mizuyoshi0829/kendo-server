<?php
    require_once dirname(__FILE__).'/autosetup_sub.php';

    $series_table = [
        'series_id' => 35,
        'result_path' => 'hses',
        'series' => [
            [
                'index' => 1,
                'update_date' => '05-01',
                'year_mode' => 'g',
                'place_num' => 4,
                'name' => '令和%d年度北信越大会',
                'name_m' => '令和%d年度北信越大会',
                'name_w' => '令和%d年度北信越大会',
                'dantai' => [
                    [
                        'mw' => 'w',
                        'league' => [
                            [ 'index' => 1, 'name' => 'Aリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 2, 'name' => 'Bリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 3, 'name' => 'Cリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 4, 'name' => 'Dリーグ', 'team_num' => 5, 'advance' => 2, ],
                        ],
                        'tournament' => [
                            [
                                'index' => 1,
                                'name' => '',
                                'team_num' => 8,
                                'extra_match_num' => 0,
                                'extra_name' => '',
                            ],
                        ]
                    ],[
                        'mw' => 'm',
                        'league' => [
                            [ 'index' => 1, 'name' => 'Aリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 2, 'name' => 'Bリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 3, 'name' => 'Cリーグ', 'team_num' => 5, 'advance' => 2, ],
                            [ 'index' => 4, 'name' => 'Dリーグ', 'team_num' => 5, 'advance' => 2, ],
                        ],
                        'tournament' => [
                            [
                                'index' => 1,
                                'name' => '',
                                'team_num' => 8,
                                'extra_match_num' => 0,
                                'extra_name' => '',
                            ],
                        ],
                    ],
                ],
                'kojin' => [
                    [
                        'mw' => 'w',
                        'league' => [],
                        'tournament' => [
                            [
                                'index' => 1,
                                'player_num' => 64,
                                'name' =>'',
                                'extra_match_num' => 0,
                                'extra_name' => '',
                                'relative' => 0,
                                'relative_start' => 0,
                                'relative_num' => 0,
                            ],
                        ]
                    ],[
                        'mw' => 'm',
                        'league' => [],
                        'tournament' => [
                            [
                                'index' => 1,
                                'player_num' => 64,
                                'name' =>'',
                                'extra_match_num' => 0,
                                'extra_name' => '',
                                'relative' => 0,
                                'relative_start' => 0,
                                'relative_num' => 0,
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ];

    setup( $series_table, null );
