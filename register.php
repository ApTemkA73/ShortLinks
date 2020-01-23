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
    <h2>Регистрация</h2>
<p>
<form action="/register.php" method="POST">
	<strong>Ваш логин</strong>
	<input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>

	<strong>Ваш пароль</strong>
	<input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>

	<strong>Повторите пароль</strong>
	<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>"><br/>

	<button type="submit" name="do_reg">Регистрация</button>
</form>
</p>
  
<?php
	if ( isset($data['do_reg']) )
	{
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин';
		}

		if ( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		if ( R::count('users', "login = ?", array($data['login'])) > 0)
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}

		if ( empty($errors) )
		{
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
			R::store($user);
			echo '<div style="color:dreen;">Вы успешно зарегистрированы!</div>';
		}else
		{
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div>';
		}
	}
?>
</div> 
  <div class="footer">&copy; 2020</div>
 </body>
</html>