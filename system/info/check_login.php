<?php
function ifLogin(): bool
{
    session_start();
    if (!empty ($_SESSION ['user'])) {
        return false;
    }
    else {
        return true;
    }
}