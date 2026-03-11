<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.global', function () {
    return true;
});
