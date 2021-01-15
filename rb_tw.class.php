<?php
/*
By Moonlight#6666
Original : https://github.com/MinecraftChannel/VoucherTopup


Example: 

	require_once("rb_tw.class.php");
	$tc = new rb_gift();
	$vc = (object) $tc->RedeemVoucher('https://gift.truemoney.com/campaign/?v=hEw65EakgOIlamlen1','mobile_no');
			
	if($vc->status['code'] != 'SUCCESS'){
		$response["status"] = 'error'; 
		$response["message"] = $vc->status['code'];
	}else{
		if($vc->data['voucher']['member'] != "1"){
			$response["status"] = 'error'; 
			$response["message"] = "ผู้รับซองของขวัญจะต้องมีแค่ 1 คน";
		}else{
			$amount = $vc->data['voucher']['amount_baht'];
			$response["status"] = 'success'; 
			$response["message"] = 'Success! Amount: ' . $vc->data['voucher']['amount_baht'];
		}
	}

*/

class rb_gift {
	function RedeemVoucher($hash = null,$phone = null) {
        if (is_null($hash) || is_null($phone)) return false;
        $ch = curl_init();
	$hash = explode('?v=',$hash)[1];
        $headers  = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $postData = [
            'mobile' => $phone,
            'voucher_hash' => $hash;
        ];
        curl_setopt($ch, CURLOPT_URL,"https://gift.truemoney.com/campaign/vouchers/$hash/redeem");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result     = curl_exec ($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return json_decode($result,true);
    }
}
