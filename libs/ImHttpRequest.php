<?php 
namespace libs;
class ImHttpRequest{
	public static function request($url,$params,$method='GET'){
		$response = null;
		if($url){
			$method = strtoupper($method);
			if($method == 'POST'){

			}elseif($method == 'PUT'){

			}elseif($method == 'DELETE'){

			}else{
				// var_dump(strrpos($url, '?'));
				if(is_array($params) and count($params)){
					if(strrpos($url, '?')){
						$url = $url.'&'.http_build_query($params);
					}else{
						$url = $url.'?'.http_build_query($params);
					}
					$response = file_get_contents($url);
				}
			}
		}
		return $response;
	}
}
