<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function success_message($msg = '成功',$data='',$code = 200)
    {	

			$ret = array('code'=>$code,'data'=>$data,'msg'=>$msg);
    		die(json_encode($ret));
    }

    public function error_message($msg='失败',$data='',$code = 501)
    {	
		    $ret = array('code'=>$code,'data'=>$data,'msg'=>$msg);
            die(json_encode($ret));
    }

    public function tableData($total = 0,$data = [],$msg='',$code=200,$pages = null)
    {
            $ret = array('code'=>$code,'data'=>$data,'msg'=>$msg,'total'=>$total,'pages'=>$pages);
            die(json_encode($ret));       
    }

    public function label($data)
    {
        if(empty($data))
        {
            return false;
        }
        return explode('-',$data);
    }
    public function baseKey($arr,$code='set')
    {   
        if(!$arr|| $code == NULL)
        {
            return false;
        }
        $getKeys = '';
        switch ($code) {
            case 'set':
                $i = 1;
                foreach($arr as $key => $val)
                {   
                    if($i == 1)
                    {   
                        $getKeys .= '?'.$key.'='.$val;
                    }else
                    {
                        $getKeys .= '&'.$key.'='.$val;
                    }
                    $i ++;
                }
                // $getKeys = base64_encode($getKeys);
                break;
            
            case 'get':
                // $getKeys = base64_decode($arr);
                break;
        }

        return $getKeys;
    }
}
