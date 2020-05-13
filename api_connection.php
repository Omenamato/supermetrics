<?php

require_once('process_posts.php');

class ApiConnection extends ProcessPosts{
    private $client_id = "ju16a6m81mhid5ue1z3v2g0uh";
    private $email = "test@email.com";
    private $name = "Tester";

    private $register_url = "https://api.supermetrics.com/assignment/register";
    private $posts_url = "https://api.supermetrics.com/assignment/posts";

    // Register token
    function register_token() {
        $params = array(
            "client_id" => $this->client_id,
            "email" => $this->email,
            "name" => $this->name
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->register_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    // Fetch posts
    function fetch_posts($sl_token, $page) {
        $params = "sl_token=".urlencode($sl_token)."&page=".$page;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->posts_url.'?'.$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
