<?php

/**
 * @Author: Ramy-Badr-Ahmed
 * @Desc: SWH API Client
 * @Repo: https://github.com/Ramy-Badr-Ahmed/swh-client
 */

namespace Module\DataType;

interface SwhDataType
{
    const HEADING = "swh";
    const VERSION = 1;
    const COLON = ':';
    public const SEPARATOR = [
        'colon'=>':',
        'semicolon'=>';'
    ];
    const INITIALS = [
        "ori","snp", "rev", "rel", "dir", "cnt"
    ];

    public function getSwhid(): string;
    public function EBNF(string &$id): bool;
    public function __set($name, $value);
    public function __get($name);

}
