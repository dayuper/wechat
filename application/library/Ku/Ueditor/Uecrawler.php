<?php

/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14
 * Time: 下午19:18
 */
namespace Ku\Ueditor;

class Uecrawler {
	static function Uecrawler($CONFIG) {
		set_time_limit ( 60 );
		
		/* 上传配置 */
		$config = array (
				"pathFormat" => $CONFIG ['catcherPathFormat'],
				"maxSize" => $CONFIG ['catcherMaxSize'],
				"allowFiles" => $CONFIG ['catcherAllowFiles'],
				"oriName" => "remote.png" 
		);
		$fieldName = $CONFIG ['catcherFieldName'];
		
		/* 抓取远程图片 */
		$list = array ();
		if (isset ( $_POST [$fieldName] )) {
// 			$source = \Ku\Tool::filter($_POST [$fieldName]);
			$source = $_POST [$fieldName];
		} else {
// 			$source = \Ku\Tool::filter($_GET [$fieldName]);
			$source = $_GET [$fieldName];
		}
		foreach ( $source as $imgUrl ) {
			$item = new \Ku\Ueditor\Uploader ( $imgUrl, $config, "remote" );
			$info = $item->getFileInfo ();
			array_push ( $list, array (
					"state" => $info ["state"],
					"url" => $info ["url"],
					"size" => $info ["size"],
					"title" => htmlspecialchars ( $info ["title"] ),
					"original" => htmlspecialchars ( $info ["original"] ),
					"source" => htmlspecialchars ( $imgUrl ) 
			) );
		}
		
		/* 返回抓取数据 */
		return json_encode ( array (
				'state' => count ( $list ) ? 'SUCCESS' : 'ERROR',
				'list' => $list 
		) );
	}
}