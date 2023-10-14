<?php

use DB;

function getTime () {
    return date('Y-m-d H:i:s');
}

function formatTime($field) {
    return "DATE_FORMAT({$field}, '%d/%m/%Y %H:%i:%s') as created_at";
}
