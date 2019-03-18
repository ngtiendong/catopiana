<?php
/**
 * Created by PhpStorm.
 * User: khoinx
 * Date: 1/3/18
 * Time: 3:18 PM
 */

namespace Modules\Core\Lib;


class NewsService
{
    private $project_code = 'erroscare';

    /**
     * Get list
     *
     * @return mixed
     */
    public function getList($cate_id = 0, $page = 1, $page_size = 10, $keySearch = '', $count = 0)
    {
        $dcurl = new Dcurl(env('NEWS_URL_API') . 'news/list');
        $data = $dcurl->postData(array(
            'project_code'=>$this->project_code,
            'cate_id'=>$cate_id,
            'page'=>$page,
            'page_size'=>$page_size,
            'user_type'=>2,//Admin
            'key'=>$keySearch
        ));
        $data = json_decode($data, true);
        if (!empty($data) && $data['result'] == 1) {
            if ($count == 1) {
                return $data;
            }
            return $data['data']['posts'];
        }
        return array();
    }
    
    /**
     * Get detail news
     *
     * @param $post_id
     * @return mixed
     */
    public function getDetail($post_id){
        $dcurl = new Dcurl(env('NEWS_URL_API') . 'news/detail');
        $data = $dcurl->postData(
            array(
                'project_code'=>$this->project_code,
                'post_id'=>$post_id
            )
        );
        return $data;
    }
    
}