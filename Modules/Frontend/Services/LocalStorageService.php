<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\CustomerTesting;

class LocalStorageService
{
    // luwu baif test leen serve
    // luc get testing : answer , current_index = answer.lenght , html_arr = content['html_arr'], level_temp = content['level_temp'], question_data = content['question_data'] , status,  
    public function createTesting($local_storage)
    {
        foreach($local_storage['question'] as $local_storage_item)
        {
            $content = [
                'question_data' => $local_storage_item['question_data'],
                'level_temp' => $local_storage_item['level_temp'],
                'type' => $local_storage_item['type'],
                'topic' => $local_storage_item['topic'],
                'test_level' => $local_storage['level'],
                'received_free_package_status' => $local_storage['received_free_package_status'],
                'count_correct_answer' => $local_storage_item['count_correct_answer']
            ];
            CustomerTesting::create([
                'customer_id' => auth()->guard('customers')->user()->id,
                'curriculum_id' => json_encode($local_storage_item['curriculum_ids']),
                'content' => json_encode($content),
                'answer' => json_encode(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []),
                'time_finish' => null,
                'score' => null,
                'status' => sizeof(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []) == sizeof($local_storage_item['question_data']) ? 1 : 0
            ]);
        }
        
    }
    // lay bai test tra lai local_storage
    public function getTesting()
    {
        $customer = auth()->guard('customers')->user();
        $testing = $customer->customer_testing;
        $data_response = [];
        foreach ($testing as $key => $testing_item) {
            // dd(json_decode($testing_item->content));
            $question_data = json_decode($testing_item->content)->question_data;
            $answers = json_decode($testing_item->answer);
            $curriculum_ids = json_decode($testing_item->curriculum_id);
            $level_temp = json_decode($testing_item->content)->level_temp;
            $status = $testing_item->status;
            $current_index = sizeof($answers) == 6 ? sizeof($answers) - 1 : sizeof($answers) ;
            $type  = json_decode($testing_item->content)->type;
            $topic  = json_decode($testing_item->content)->topic;
            $data_response[$key] = [
                'question_data' => $question_data,
                'answers' => $answers,
                'curriculum_ids' => $curriculum_ids,
                'level_temp' => $level_temp,
                'status' => $status,
                'current_index' => $current_index,
                'type' => $type,
                'topic' => $topic,
                'level' => json_decode($testing_item->content)->test_level,
                'customer_testing_id' => $testing_item->id,
                'received_free_package_status' => json_decode($testing_item->content)->received_free_package_status,
                'count_correct_answer' => json_decode($testing_item->content)->count_correct_answer
            ]; 
        }
        return $data_response;
    }
    // update bai test hoac tao moi,
    public function updateTesting($local_storage)
    {
        $customer = auth()->guard('customers')->user();
        foreach($local_storage['question'] as $local_storage_item)
        {
            $content = [
                'question_data' => $local_storage_item['question_data'],
                'level_temp' => $local_storage_item['level_temp'],
                'type' => $local_storage_item['type'],
                'topic' => $local_storage_item['topic'],
                'test_level' => $local_storage['level'],
                'received_free_package_status' => $local_storage['received_free_package_status'],
                'count_correct_answer' => $local_storage_item['count_correct_answer']
            ];
            CustomerTesting::updateOrCreate(
                ['id' => $local_storage_item['customer_testing_id'] ,'customer_id' => $customer->id ],
                [
                    'curriculum_id' => json_encode($local_storage_item['curriculum_ids']),
                    'content' => json_encode($content),
                    'answer' => json_encode(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []),
                    'time_finish' => null,
                    'score' => null,
                    'status' => sizeof(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []) == sizeof($local_storage_item['question_data']) ? 1 : 0
                ]
            );
        }
    }

    // update 1 topic khi nguoi dung da sign in 
    public function updateThisQuestion($local_storage_item, $level)
    {
        $customer = auth()->guard('customers')->user();
        $content = [
            'question_data' => $local_storage_item['question_data'],
            'level_temp' => $local_storage_item['level_temp'],
            'type' => $local_storage_item['type'],
            'topic' => $local_storage_item['topic'],
            'test_level' => $level,
            'count_correct_answer' => $local_storage_item['count_correct_answer']
        ];
        $this_testing = CustomerTesting::updateOrCreate(
            ['id' => $local_storage_item['customer_testing_id'] ,'customer_id' => $customer->id ],
            [
                'curriculum_id' => json_encode($local_storage_item['curriculum_ids']),
                'content' => json_encode($content),
                'answer' => json_encode(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []),
                'time_finish' => null,
                'score' => null,
                'status' => sizeof(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []) == sizeof($local_storage_item['question_data']) ? 1 : 0
            ]
        );
        return $this_testing->id;
    }
}
