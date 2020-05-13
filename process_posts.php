<?php

class ProcessPosts {
    function count_stats($posts) {
        // Get stats
        $avg_char_lenght_per_month = $this->count_avg_char_lenght($posts);
        $longest_post_per_month = $this->find_longest_post($posts);
        $total_posts_per_week = $this->count_total_post($posts);
        $avg_user_posts_per_month = $this->count_user_avg_post_number($posts);

        // Print stats
        print_r('Average character length of a post/month'."\n");
        print_r($avg_char_lenght_per_month);
        print_r("\n");

        print_r('Longest post by character length/month'."\n");
        print_r($longest_post_per_month);
        print_r("\n");

        print_r('Total posts split by week'."\n");
        print_r($total_posts_per_week);
        print_r("\n");

        print_r('Average number of posts per user/month'."\n");
        print_r($avg_user_posts_per_month);
        print_r("\n");
    }

    // Average character length of a post/month
    function count_avg_char_lenght($posts) {
        // Construct monthdata
        $monthdata = array();
        foreach ($posts as $key => $value) {
            if (!array_key_exists(date('mY', strtotime($value->created_time)), $monthdata)) {
                $monthdata[date('mY', strtotime($value->created_time))][] = $value;
            } else {
                array_push($monthdata[date('mY', strtotime($value->created_time))], $value);
            }
        }

        // Count average
        foreach ($monthdata as $posts) {
            $lenghts = array();
            foreach ($posts as $post) {
                $lenghts[] = strlen($post->message);
                $month = date('mY', strtotime($post->created_time));
            }
            $avg[$month] = round(array_sum($lenghts) / count(array_keys($posts)), 2);
        }
        return $avg;
    }

    // Longest post by character length/month
    function find_longest_post($posts) {
        // Construct monthdata
        $monthdata = array();
        foreach ($posts as $key => $value) {
            if (!array_key_exists(date('mY', strtotime($value->created_time)), $monthdata)) {
                $monthdata[date('mY', strtotime($value->created_time))][] = $value;
            } else {
                array_push($monthdata[date('mY', strtotime($value->created_time))], $value);
            }
        }

        // Find longest
        foreach ($monthdata as $posts) {
            $lenght = 0;
            foreach ($posts as $post) {
                if (strlen($post->message) > $lenght) {
                    $lenght = strlen($post->message);
                    $month = date('mY', strtotime($post->created_time));
                    $longest[$month] = $post;
                }
            }
        }
        return $longest;
    }

    // Total posts split by week
    function count_total_post($posts) {
        // Construct weekdata
        $weekdata = array();
        foreach ($posts as $key => $value) {
            if (!array_key_exists(date('WY', strtotime($value->created_time)), $weekdata)) {
                $weekdata[date('WY', strtotime($value->created_time))][] = $value;
            } else {
                array_push($weekdata[date('WY', strtotime($value->created_time))], $value);
            }
        }

        // Count total
        foreach ($weekdata as $posts) {
            $count = count(array_keys($posts));
            $week = date('WY', strtotime($posts[0]->created_time));
            $total[$week] = $count;
        }
        return $total;
    }

    // Average number of posts per user/month
    function count_user_avg_post_number($posts) {
        // Construct monthdata
        $userdata = array();
        foreach ($posts as $key => $value) {
            if (!array_key_exists(date('mY', strtotime($value->created_time)), $userdata) || !array_key_exists($value->from_id, $userdata)) {
                $userdata[$value->from_id][date('mY', strtotime($value->created_time))][] = $value;
            }
        }

        // Count average
        foreach ($userdata as $months) {
            $postcount = 0;
            $monthcount = count($months);
            foreach ($months as $posts) {
                $user_id = $posts[0]->from_id;
                $postcount = $postcount + count($posts);
            }
            $avg[$user_id] = round($postcount / $monthcount, 2);
        }
        return $avg;
    }
}
