<?php

namespace App\Repositories;
use App\Topic;

class TopicRepository {

    public function getTopic($topic){
        
        return Topic::where('topic','like','%'.$topic.'%')->limit('5')->get();
    }

}

?>