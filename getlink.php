<?php 
	require 'db.php';
	$link = $_POST['link'];
	function is_url($in)
	{ 
		$w = "a-z0-9"; 
		$url_pattern = "#( 
		(?:f|ht)tps?://(?:www.)? 
		(?:[$w\\-.]+/?\\.[a-z]{2,4})/? 
		(?:[$w\\-./\\#]+)? 
		(?:\\?[$w\\-&=;\\#]+)? 
		)#xi";
		$a = preg_match($url_pattern,$in); 
		return $a; 
	}
	function check_domain_availible($domain)
	{
		if (!filter_var($domain, FILTER_VALIDATE_URL))
			return false;

		$curlInit = curl_init($domain);
		curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curlInit, CURLOPT_HEADER, true);
		curl_setopt($curlInit, CURLOPT_NOBODY, true);
		curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curlInit);
		curl_close($curlInit);

		if ($response) 
			return true;
		return false;
	}
	
	function generatelink($length = 5){
		$chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
		$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}
	if (is_url("$link"))
	{
		if (check_domain_availible("$link"))
		{
				$genlink = generatelink(5);
				$links = R::dispense('links');
				$links->iduser = "000";
				if ( isset ($_SESSION['logged_user']) )
				{
					$links->iduser = $_SESSION['logged_user']->id;
				}
					$links->linkin = "$link";
					$links->linkout = $genlink;
					R::store($links);
					echo json_encode(array(
					'result' => 'Ссылка успешно сокращена, короткий URL:',
					'linkout' => $genlink));
		}
		else
		{
				echo json_encode(array(
					'result' => 'Страница которую Вы хотите сократить не доступна.',
					'linkout' => '0'
					));
		}
	}
	else
	{
		echo json_encode(array(
		'result' => 'Неправильный ввод url',
		'linkout' => '0'
		));
	}

		
?>