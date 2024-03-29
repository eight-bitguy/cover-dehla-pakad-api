<?php

namespace App\Http;

class ResponseErrors
{
    const ROOM_IS_INACTIVE = 'ROOM_IS_INACTIVE';
    const ROOM_IS_FULL = 'ROOM_IS_FULL';
    const ROOM_IS_NOT_FULL = 'ROOM_IS_NOT_FULL';
    const ROOM_IS_NOT_ACTIVE = 'ROOM_IS_NOT_ACTIVE';

    const USER_NOT_FOUND = 'USER_NOT_FOUND';
    const USER_IS_NOT_ROOM_ADMIN = 'USER_IS_NOT_ROOM_ADMIN';
    const USER_NOT_PRESENT_IN_ROOM = 'USER_NOT_PRESENT_IN_ROOM';
    const NO_USER_CHANCE = 'NO_USER_CHANCE';

    const INVALID_TOKEN = 'INVALID_TOKEN';
    const INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    const INVALID_USER_CHANCE = 'INVALID_USER_CHANCE';
    const INVALID_CARD = 'INVALID_CARD';

    const CARD_NOT_PRESENT_WITH_USER = 'CARD_NOT_PRESENT_WITH_USER';

    const TOKEN_EXPIRED = 'TOKEN_EXPIRED';
    const TOKEN_NOT_FOUND = 'TOKEN_NOT_FOUND';

    const COULD_NOT_CREATE_TOKEN = 'COULD_NOT_CREATE_TOKEN';
    const USER_CANNOT_OPEN_TRUMP = 'USER_CANNOT_OPEN_TRUMP';
}
