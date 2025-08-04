<?php
$month = date('n'); // numeric month (1 to 12)
$year = date('Y');

if ($month >= 4) {
    // April to December → session starts this year
    $current_session = $year . '-' . substr($year + 1, -2);
    echo $current_session;
} else {
    // Jan to March → session is of previous year
    $current_session = ($year - 1) . '-' . substr($year, -2);
    echo $current_session;
}

?>
