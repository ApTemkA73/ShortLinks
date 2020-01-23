<?php 
	require 'db.php';
	if(isset($_GET['id'])){
		$link = $_GET['id'];
		 if ( isset ($_SESSION['logged_user']) )
		 {
			 $userid = $_SESSION['logged_user']->id;
			 $searhuserid = R::findOne ('links', "linkout = ?", ["$link"]);
			 $useridbylink = $searhuserid['iduser'];
			 if($userid == $useridbylink){
				 //проверяем, вдруг пользователь хочет удалить ссылку другого пользователя :C
				R::hunt('links', 'linkout = ?', ["$link"]);
				echo "Ссылка успешно удалена<br/>Перенаправляю обратно...";
				echo '<meta http-equiv="refresh" content="1;URL=/mylinks.php">';
			 }
		 }
	}
?>