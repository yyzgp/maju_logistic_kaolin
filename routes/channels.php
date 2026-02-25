<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('location', function () {
    return true;
});

Broadcast::channel('online-status', function () {
    return true;
});
