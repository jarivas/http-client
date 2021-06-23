<?php

echo json_encode([
    'method' => $_SERVER['REQUEST_METHOD'],
    'get_params' => $_GET,
    'body' => file_get_contents('php://input'),
    'post_params' => $_POST
]);