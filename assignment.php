<?php

require_once('api_connection.php');

// Connect to API
$get_connection = new ApiConnection();
$token = json_decode($get_connection->register_token());

$all_posts = new stdClass();

// Get posts from API and put them to object
for ($i = 1; $i <= 10; $i++) {
    $post_data = json_decode($get_connection->fetch_posts($token->data->sl_token, $i));
    $all_posts = (object) array_merge((array) $all_posts, (array) $post_data->data->posts);
}

// Get stats and print them
$process_posts = new ProcessPosts;
$stats = $process_posts->count_stats($all_posts);

print_r($stats);

print_r('Time elapsed: ');
print_r(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"].' seconds');
