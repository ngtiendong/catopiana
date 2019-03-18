<?php

if ( ! function_exists('category_parent')) {
    $all = [];
    function category_parent ($data, $parent = 0, $str = '')
    {
        $category = [];
        foreach($data as $val){
            if ($val->parent_id == $parent) {
                $category[] = ['id' => $val->id, 'name' => $str.$val->name, 'parent_id' => $val->parent_id, 'slug' => $val->slug ];
                $tmpArray = category_parent($data, $val->id,$str.'--');
                $category = $category + $tmpArray;
            }
        }

        return $category;
    }
}

if (! function_exists('menuAdd')) {

    function menuAdd($data,$parent=0,$str='')
    {
        foreach($data as $val){
            if ($val->parent_id==$parent) {
                echo "<option value='".$val->id."'>".$str.$val->name."</option>";
                menuAdd($data,$val->id,$str.'--');
            }
        }
    }

}

if ( ! function_exists('menuEdit')) {

    function menuEdit($data,$itemCat,$parent=0,$str='')
    {
        foreach ($data as $val) {
            if ($val->parent_id==$parent) {
                $select = ($itemCat==$val->id)?'selected':'';
                echo "<option $select value='".$val->id."'>".$str.$val->name."</option>";
                menuEdit($data,$itemCat,$val->id,$str.'--');
            }
        }
    }
}


?>