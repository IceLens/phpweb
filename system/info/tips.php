<?php

function tips($type) :string
{
    //$i = mt_rand();
    //Tips for login
    if ($type == 0){
        $tips = array('请登录在浏览哦','记得先登录','您还没有登录');
        return $tips[rand(0,2)];
    }
    //File err
    elseif ($type == 1){
        $tips = array('文件不能为空','您没有选择文件','请检查是否选择文件');
        return $tips[rand(0,2)];
    }
    //File movement
    elseif ($type == 2){
        $tips = array('上传失败','文件处理出错','出了点问题,等待一会再试试','出问题了,真不行请联系管理');
        return $tips[rand(0,3)];
    }
    elseif ($type == 3){
        $tips = array('请勿重复上传','您以及上传过了','要不重置一下上传');
        return $tips[rand(0,2)];
    }
    else{
        return 'Error';
    }
}
