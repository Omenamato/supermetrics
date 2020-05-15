<?php

class ProcessPosts {
    
    private $timegroups = array(
        'month' => 'mY',
        'week'  => 'WY'
    );

    function count_stats($posts) {
        // Get stats
        $results = array(
            'Average character length of a post/month'  => $this->count_avg_char_lenght($posts), 
            'Longest post by character length/month'    => $this->find_longest_post($posts),
            'Total posts split by week'                 => $this->count_total_post($posts),
            'Average number of posts per user/month'    => $this->count_user_avg_post_number($posts)
        );
        return $results;
    }

    // Average character length of a post/month
    function count_avg_char_lenght($posts) {
        // Construct monthdata
        $month_data = $this->construct_data($posts, 'month');

        // Count average
        foreach ($month_data as $posts) {
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
        $month_data = $this->construct_data($posts, 'month');

        // Find longest
        foreach ($month_data as $posts) {
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
        $week_data = $this->construct_data($posts, 'week');

        // Count total
        foreach ($week_data as $posts) {
            $count = count(array_keys($posts));
            $week = date('WY', strtotime($posts[0]->created_time));
            $total[$week] = $count;
        }
        return $total;
    }

    // Average number of posts per user/month
    function count_user_avg_post_number($posts) {
        // Construct data by user
        $userdata = $this->construct_data($posts, 'month', true);

        // Count average
        foreach ($userdata as $months) {
            $post_count = 0;
            $month_count = count($months);
            foreach ($months as $posts) {
                $user_id = $posts[0]->from_id;
                $post_count = $post_count + count($posts);
            }
            $avg[$user_id] = round($post_count / $month_count, 2);
        }
        return $avg;
    }

    function construct_data($posts, $timegroup, $usergroup = false) {
        // Search timekey
        if (array_key_exists($timegroup, $this->timegroups)) {
            $timekey = $this->timegroups[$timegroup];
        } else {
            throw new Exception('Timegroup is missing or invalid.');
        }

        // Construct data
        $data = array();
        foreach ($posts as $key => $value) {
            if ($usergroup) {
                if (!array_key_exists(date($timekey, strtotime($value->created_time)), $data) || !array_key_exists($value->from_id, $data)) {
                    $data[$value->from_id][date($timekey, strtotime($value->created_time))][] = $value;
                }
            } else if (!array_key_exists(date($timekey, strtotime($value->created_time)), $data)) {
                $data[date($timekey, strtotime($value->created_time))][] = $value;
            } else {
                array_push($data[date($timekey, strtotime($value->created_time))], $value);
            }
        }
        return $data;
    }
}
