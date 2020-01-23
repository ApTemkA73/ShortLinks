<?php 
	require 'db.php';
	$data = $_POST;
		 if ( isset ($_SESSION['logged_user']) )
		 header('Location: index.php');
	 
?>



<html>

 <head>
  <title>Сократитель ссылок</title>
  <style>
  
 body {
    font: 14px Arial, Helvetica, sans-serif;
    margin: 0;
   }
   h1 {
    font-size: 36px;
    margin: 0;
    color: #fc6;
   }
   h2 {
    margin-top: 0;
   }
   .header {
    background: #0080c0;
    padding: 10px;
   }
   .sidebar {
    float: right;
    border: 1px solid #333;
    width: 20%;
    padding: 5px;
    margin: 10px 10px 20px 5px;
   }
   .content {
    margin: 10px 25% 20px 5px;
    padding: 5px;
    border: 1px solid #333;
   }
   .footer {
    background: #333;
    padding: 5px;
    color: #fff;
    clear: left;
   }
  </style>

 </head>
 <body>
  <div class="header"><h1>Сократитель ссылок</h1></div>
	<div class="sidebar">
	<p><a href="/">Главная</a></p>
    <p><a href="login.php">Войти</a></p>
	 <p><a href="register.php">Нет аккаунта?</a></p>
	 </div>
	   <div class="content">
    <h2>Авторизация</h2>
<p>
<form action="login.php" method="POST">
	<strong>Логин</strong>
	<input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>

	<strong>Пароль</strong>
	<input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>
	<button type="submit" name="do_login">Войти</button>
</form>
<?php
if ( isset($data['do_login']) )
	{
		$user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			if ( password_verify($data['password'], $user->password) )
			{
				$_SESSION['logged_user'] = $user;
				echo '<div style="color:dreen;">Вы авторизованы!<br/> Можете перейти на <a href="/">главную</a> страницу.</div>';
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}
		
		if ( ! empty($errors) )
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div>';
		}

	}
?>
	

</p>
  </div>  
  <div class="footer">&copy; 2020</div>
 </body>
</html>