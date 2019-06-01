<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Entities\Curriculum;
use Modules\Frontend\Entities\Package;
use Modules\Frontend\Entities\CustomerTesting;
use Modules\Frontend\Entities\GuestTesting;
use Illuminate\Support\Str;

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
                'count_correct_answer' => $local_storage_item['count_correct_answer'],
                'result' => $local_storage_item['result']
            ];
            CustomerTesting::create([
                'customer_id' => auth()->guard('customers')->user()->uuid,
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
    public function getTesting($guest_id = null)
    {
        if($guest_id == null) {
            $customer = auth()->guard('customers')->user();
            $testing = $customer->customer_testing;
        } else {
            $testing = CustomerTesting::where('customer_id', $guest_id)->where('guest', 1)->get();
        }

        $data_response = [];
        foreach ($testing as $key => $testing_item) {
            $question_data = json_decode($testing_item->content)->question_data;
            $answers = json_decode($testing_item->answer);
            $curriculum_ids = json_decode($testing_item->curriculum_id);
            $level_temp = json_decode($testing_item->content)->level_temp;
            $status = $testing_item->status;
            $current_index = sizeof($answers) == sizeof($question_data) ? sizeof($answers) - 1 : sizeof($answers);
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
                'count_correct_answer' => json_decode($testing_item->content)->count_correct_answer,
                'result' => json_decode($testing_item->content)->result
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
                'count_correct_answer' => $local_storage_item['count_correct_answer'],
                'result' => $local_storage_item['result']
            ];
            CustomerTesting::updateOrCreate(
                ['id' => $local_storage_item['customer_testing_id'] ,'customer_id' => $customer->uuid ],
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
    public function updateThisQuestion($local_storage_item, $level, $received_free_package_status, $guest_id = null)
    {
        if ($guest_id == null) {
            $customer_id = auth()->guard('customers')->user()->uuid;
            $guest = 0;
        } else {
            $customer_id = $guest_id;
            $guest = 1;
        }
        $content = [
            'question_data' => $local_storage_item['question_data'],
            'level_temp' => $local_storage_item['level_temp'],
            'type' => $local_storage_item['type'],
            'topic' => $local_storage_item['topic'],
            'test_level' => $level,
            'received_free_package_status' => $received_free_package_status,
            'count_correct_answer' => $local_storage_item['count_correct_answer'],
            'result' => $local_storage_item['result']
        ];
        $this_testing = CustomerTesting::updateOrCreate(
            ['id' => $local_storage_item['customer_testing_id'] ,'customer_id' => $customer_id ],
            [
                'guest' => $guest,
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

    // save guest'testing
    public function saveNewGuestTesting($local_storage)
    {
        $guest_id = Str::uuid();
        foreach($local_storage['question'] as $local_storage_item)
        {
            $content = [
                'question_data' => $local_storage_item['question_data'],
                'level_temp' => $local_storage_item['level_temp'],
                'type' => $local_storage_item['type'],
                'topic' => $local_storage_item['topic'],
                'test_level' => $local_storage['level'],
                'received_free_package_status' => $local_storage['received_free_package_status'],
                'count_correct_answer' => $local_storage_item['count_correct_answer'],
                'result' => $local_storage_item['result']
            ];
            CustomerTesting::create([
                'guest' => 1,
                'customer_id' => $guest_id,
                'curriculum_id' => json_encode($local_storage_item['curriculum_ids']),
                'content' => json_encode($content),
                'answer' => json_encode(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []),
                'time_finish' => null,
                'score' => null,
                'status' => sizeof(isset($local_storage_item['answers']) ? $local_storage_item['answers'] : []) == sizeof($local_storage_item['question_data']) ? 1 : 0
            ]);
        }
        return $guest_id;
    }

    public function changeGuestIntoCustomer($guest_id, $customer_id)
    {
        $result = CustomerTesting::where('customer_id', $guest_id)->where('guest', 1)->update(['customer_id' => $customer_id ,'guest' => 0 ]);
        return ;
    }

    public function removeLocalStorateDB($guest_id)
    {
        if ($guest_id == '-1') {
            auth()->guard('customer')->user()->customer_testing()->delete();
        } else {
            $test_ids = CustomerTesting::where('customer_id', $guest_id)->where('guest', 1)->get(['id'])->toArray();
            CustomerTesting::destroy($test_ids);
        }
    }

    public function removeLocalStorateFreeTest($guest_id)
    {
        $package_free = Package::where('type', 0)->first();
        $free_curriculums = $package_free->curriculums->pluck('id')->toArray();
        $test_delete_ids = [];
        if ($guest_id == '-1') {
            $currs = auth()->guard('customers')->user()->customer_testing()->pluck('curriculum_id','id')->toArray();
        } else {
            $currs = CustomerTesting::where('customer_id', $guest_id)->where('guest', 1)->pluck('curriculum_id','id')->toArray();
        }
        foreach ($currs as $test_id => $curr) {
            if(in_array((int)json_decode($curr)[0], $free_curriculums)) {
                $test_delete_ids[] = $test_id;
            }
        }

        CustomerTesting::destroy($test_delete_ids);
    }

    public function updateReceivePackageStatus($guest_id)
    {
        if ($guest_id == '-1') {
            $tests = auth()->guard('customers')->user()->customer_testing()->get();
        } else {
            $tests = CustomerTesting::where('customer_id', $guest_id)->where('guest', 1)->get();
        }

        foreach ($tests as $test) {
            $test_ob = json_decode($test->content);
            $test_ob->received_free_package_status = "1";
            $new_conttent = json_encode($test_ob);
            $test->content = $new_conttent;
            $test->save();
        }
    }
}
