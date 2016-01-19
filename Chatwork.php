<?php

/*
 * Chatwork API操作クラス
 * @source: http://developer.chatwork.com/ja/
 * ex)	$ch = new Chatwork('[API token]');
 *		$roomid = $ch->getRoomID('[Room name]');
 *		$ch->sendMessage($roomid, "[Message]");
 *
*/

class Chatwork {

	private $tokenHeaderKey = "X-ChatWorkToken: ";
	private $apiToken;		//APIトークン
	private $reqHeader;		//リクエストヘッダ
	private $room = [];			//ルームＩＤ

	/*
	 * コンストラクタ
	 * $apiToken: 自分のＡＰＩトークン
	*/
	public function __construct($apiToken) {
		$this->apiToken = $apiToken;
		$this->reqHeader = ["{$this->tokenHeaderKey}{$this->apiToken}"];
		$this->getRooms();
	}

	/*
	 * ルーム一覧を取得
	 * $apiToken: 自分が所属する部屋の一覧を取得
	*/
	private function getRooms() {
		$uri = "https://api.chatwork.com/v1/rooms";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->reqHeader);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = json_decode(curl_exec($ch));
		curl_close($ch);

		foreach ($ret as $r) {
			$this->room[$r->name] = $r->room_id;
		}
	}

	/*
	 * ルームＩＤを取得
	 * $roomName: ルーム名
	 * return: ルームＩＤ、見つからない場合false
	*/
	public function getRoomID($roomName) {
		return isset($this->room[$roomName]) ? $this->room[$roomName] : false;
	}


	/*
	 * ルームIDを指定してメッセージを送る
	 * $roomid: ルームＩＤ
	 * $msg: 送信メッセージ（改行は\n）
	*/
	public function sendMessage($roomid, $msg) {
		// リクエストURI
		$uri = "https://api.chatwork.com/v1/rooms/{$roomid}/messages";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->reqHeader);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['body' => $msg]));
		curl_exec($ch);
		curl_close($ch);
	}

}
