<?php
function dayOfWeekNumber($date)
{
    return date('N', strtotime($date));
}
