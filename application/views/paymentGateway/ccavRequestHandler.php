<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php include('Crypto.php');?>
<?php 

	error_reporting(0);
	
	$merchant_data='';
	$working_key='22F45F6F17E5AAEFF614240D0282D19C';//Shared by CCAVENUES
	$access_code='AVTD00KH04BJ04DTJB';//Shared by CCAVENUES
      	$data =  array();
      	$data['tid']=$tid;
      	$data['merchant_id']=$merchant_id;
      	$data['order_id']=$order_id;
      	$data['amount']=round($final_price,2);
      	$data['currency']=$currency;
      	$data['redirect_url']=$redirect_url;
      	$data['cancel_url']=$cancel_url;
      	$data['language']=$language;
      	$data['billing_name']=$billing_name;
      	$data['billing_address']=$billing_address;
      	$data['billing_city']=$billing_city;
      	$data['billing_state']=$billing_state;
      	$data['billing_zip']=$billing_zip;
      	$data['billing_country']=$billing_country;
      	$data['billing_tel']=$billing_tel;
      	$data['billing_email']=$billing_email;
      	$data['merchant_param1']=$merchant_param1;

    foreach ($data as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
//print_r($encrypted_data);die();

?>
<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>



