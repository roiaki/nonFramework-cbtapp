<?php

function updateCheck($index) {
    if (isset($_POST[$index]) ) {
        $habit_id = $index;
    }
    return $habit_id;
}