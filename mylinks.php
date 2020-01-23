<?php 
	require 'db.php';
		 if (! isset ($_SESSION['logged_user']) )
		 header('Location: index.php');
	 
?>

<html>
 <head>
  <title>Сократитель ссылок :3</title>
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
  <div class="header"><h1>Сократитель</h1></div>
			<div class="sidebar">
				<p>Привет, <?php echo $_SESSION['logged_user']->login; ?>!</p>
				<p><a href="/">Главная</a></p>
				<p><a href="mylinks.php">Мои ссылки</a></p>
				<p><a href="logout.php">Выйти</a></p>
			</div>

  	<div class="content">
				<h2>Ваши ссылки:</h2>
					<p>
						<?php 
							$userid = $_SESSION['logged_user']->id;
							$searсh_link = R::getAll('select linkin, linkout from links where iduser = ?', [
								$userid
								]);			
						?>
						<?php if (count($searсh_link) == 0): ?>
							<p>У Вас нет сокращенных ссылок :(</p>
							</br>
						<?php endif; ?>
						<?php if (count($searсh_link) > 0): ?>
							<table>
								<tbody>
						<?php foreach ($searсh_link as $row): array_map('htmlentities', $row); ?>
							<tr>
							<td><?= $row['linkin'] ?></td>
							<td><a href="/?go=<?= $row['linkout'] ?>">http://main.ru/?go=<?= $row['linkout'] ?></a></td>
							<td><a href="delete.php?id=<?= $row['linkout'] ?>">Удалить</a></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
							</table>
    <?php endif; ?>
					</p>
			    </div>

  
  <div class="footer">&copy; 2020</div>
 </body>
</html>