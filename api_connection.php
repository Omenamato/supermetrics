<?php

require_once('process_posts.php');

class ApiConnection extends ProcessPosts {

    // Register token
    function register_token() {
        $config = parse_ini_file('config.ini');
        $params = array(
            'client_id' => $config['client_id'],
            'email'     => $config['email'],
            'name'      => $config['name']
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $config['register_url']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $output = curl_exec($ch);

        if (curl_error($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        return json_decode($output);
    }

    // Fetch posts
    function fetch_posts($sl_token) {
        $config = parse_ini_file('config.ini');

        $ch = curl_init();

        $all_posts = new ArrayObject();

        for ($i = 1; $i <= 10; $i++) {
            $params = "sl_token=".urlencode($sl_token)."&page=".$i;
            curl_setopt($ch, CURLOPT_URL, $config['posts_url'].'?'.$params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $output = json_decode(curl_exec($ch));

            if (curl_error($ch)) {
                throw new Exception('Curl error: ' . curl_error($ch));
            }
            
            $all_posts = (object) array_merge((array) $all_posts, (array) $output->data->posts);
        }

        curl_close($ch);
        return $all_posts;
    }
}
