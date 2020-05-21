<?php

require_once('api_connection.php');

// Connect to API
$get_connection = new ApiConnection();
$token = $get_connection->register_token();

// Get posts from API and put them to object
$all_posts = new ArrayObject();
$all_posts = $get_connection->fetch_posts($token->data->sl_token);

// Get stats and print them
$process_posts = new ProcessPosts;
$stats = $process_posts->count_stats($all_posts);

print_r($stats);

print_r('Time elapsed: ');
print_r(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"].' seconds');
