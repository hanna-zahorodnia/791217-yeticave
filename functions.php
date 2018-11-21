<?php
function include_template($name, $data) {
$name = 'templates/' . $name;
$result = '';

if (!file_exists($name)) {
return $result;
}

ob_start();
extract($data);
require $name;

$result = ob_get_clean();

return $result;
}

function showTimeLeft() {
    $tomorrow_timestamp = strtotime('tomorrow midnight');
    $time_left = $tomorrow_timestamp - time();
    return date('H:i', $time_left);
}

?>
