<?php 
namespace app;
use libs\ImHttpRequest;
use libs\ImRedis;
class Queryphone{
	const TAOBAO_API = 'http://tcc.taobao.com/cc/json/mobile_tel_segment.htm';
	const CACHE_KEY = 'PHONE:INFO';
	/*查询手机号码的归属地*/
	/*
	验证手机号是否合法
	根据TAOBAO_API查看手机归属地
	将手机号信息保存到redis
	*/
	public static function query($phone){
		$ret = [];
		if(self::verifyPhone($phone)){
			// $redisKey = substr($phone, 0,7);
			$phoneInfo = ImRedis::getRedis()->hGet(self::CACHE_KEY,$phone);
			if($phoneInfo){
				$ret = json_decode($phoneInfo,true);
				$ret['msg']='由"林中落日"提供数据';
			}else{
				$response =  ImHttpRequest::request(self::TAOBAO_API,['tel'=>$phone],$method='GET');
				 $response=iconv("GBK", "UTF-8//IGNORE", $response);//直接输出$response乱码
				 $data = self::formatData($response);
				 if($data){
				 	// var_dump($data);
				 	$json = json_encode($data);
				 	ImRedis::getRedis()->hSet(self::CACHE_KEY,$phone,$json);
				 	$data['msg']='由"追风去"提供数据';
				 	$ret = $data;
					}
			}
		}else{
			$ret['msg']= '请输入有效的手机号码';
		}
		return $ret;
	}
	/*检验手机号码的合法性*/
	public static function verifyPhone($phone = null){
		$ret =false;
		if($phone){
			if(preg_match('/^1[34578]{1}\d{9}/', $phone)){
				$ret = true;
			}
		}
		return $ret;
	}
	/*将API请求回来的数据转化成数组的形式*/
	public static function formatData($data=null){
		$ret = false;
		if($data){
			preg_match_all("/(\w+):'([^']+)/", $data, $ret);
			$ret = array_combine($ret[1], $ret[2]);
		}
		return $ret;
	}
}

 ?>