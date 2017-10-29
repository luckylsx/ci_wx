<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 接入微信类
 */
class Main extends CI_Controller
{
	const TOKEN = "luckylsx";
	public function index(){
		$this->load->library("wechat",['token'=>self::TOKEN]);
		$data = $this->wechat->request();
		file_put_contents("log.txt",$data,FILE_APPEND);
		//$this->logger($data);
		if ($data && is_array($data)) {
			switch ($data['MsgType']) {
				case 'text':
					$this->Text($data);
					break;
				
				default:
					# code...
					break;
			}
		}
	}
	/**
	 * 回复文本消息
	 */
	public function Text($data){
		if (strstr($data['Content'], '文本')) {
			$text = "我正在使用ci框架开发微信";
			$this->logger("发送消息：\n".$text);
			$this->Wechat->replyText($text);
		}
	}
	/**
	 * 记录日志
	 * @param  [type] $content [日志内容]
	 * @return [type]          [description]
	 */
	public function logger($content)
	{
	$logSize=100000;
	$log="log.txt";
	if(file_exists($log) && filesize($log)>$logSize){
		unlink($log);
	}
	file_put_contents($log,date("Y-m-d H:i:s",time())." ".$content."\n",FILE_APPEND);
	}
}