<?php

// replace attribute values
$formCode = preg_replace_callback(
    '/\[ATTRIBUTE_VALUE\(([a-zA-Z]+)\)\]/',
    function ($matches) use ($values) {
        return isset($values[$matches[1]]) ? $values[$matches[1]] : '';
    },
    $formCode
);

// replace attribute names
$formCode = preg_replace_callback(
    '/\[ATTRIBUTE\(([a-zA-Z]+)\)\]/',
    function ($matches) {
        return $this->field($matches[1]);
    },
    $formCode
);

echo $formCode;