<?php 
	require 'db.php';
	if(isset($_GET['go'])){
		$link = $_GET['go'];
		$searhlink = R::findOne ('links', "linkout = ?", ["$link"]);
		if($searhlink){
			$requst = $searhlink['linkin'];
				echo "Ссылка на которую Вы переходите: $requst<br/>Перенаправляю...";
				echo "<script type='text/javascript'>document.location.href='{$requst}';</script>";
				echo '<META HTTP-EQUIV="refresh" content="2;URL=' . $requst . '">';
		}
	}


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <title>Сократитель ссылок :3</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"  type="text/javascript"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js" type = "text/javascript"></script>
    <script>
        $(document).ready(function(){
            $('#btn_submit').click(function(){
                var link    = $('#link').val();
                $.ajax({
                    url: "getlink.php",
                    type: "post",
                    dataType: "json", 
                    data: { 
                        "link":    link,
                    },
                    
                    success: function(otvet)
					{
						$('.messages').html(otvet.result);
						$('#post-shortlink').css('visibility', 'hidden');
						$('#ButtonCopy').css('visibility', 'hidden');
						if (otvet.linkout !== '0') {
							$('#post-shortlink').css('visibility', 'visible');
							$('#ButtonCopy').css('visibility', 'visible');
							$('.linktohref').html("</hr> <a href=http://main.ru/?go=" + otvet.linkout + ">http://main.ru/?go=" + otvet.linkout + "</a>" );
						}
                    }
                });
            });
        });
		function copytext(el) {
		var $tmp = $("<textarea>");
		$("body").append($tmp);
		$tmp.val($(el).text()).select();
		document.execCommand("copy");
		$tmp.remove();
} 
    </script>
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
   #ButtonCopy {visibility: hidden;}
  </style>
 </head>
 <body>
  <div class="header"><h1>Сократитель</h1></div>
  
  <?php if ( isset ($_SESSION['logged_user']) ) : ?>
			<div class="sidebar">
				<p>Привет, <?php echo $_SESSION['logged_user']->login; ?>!</p>
				<p><a href="/">Главная</a></p>
				<p><a href="mylinks.php">Мои ссылки</a></p>
				<p><a href="logout.php">Выйти</a></p>
			</div>
  <?php else : ?>
			<div class="sidebar">
				<p><a href="/">Главная</a></p>
				<p><a href="login.php">Войти</a></p>
				<p><a href="register.php">Нет аккаунта?</a></p>
			</div>
  <?php endif; ?>
  	<div class="content">
				<h2>Привет!</h2>
					<p>
						Здесь ты можешь сократить необходимую тебе ссылку:<br/>
						<input type="text" id="link" value="" /><br/>
						<input type="button" value="Отправить" id="btn_submit" />  
						<div class="messages">
						</div>
						<a class="linktohref" id="post-shortlink"></a>
						<button id="ButtonCopy" onclick="copytext('#post-shortlink')">Скопировать</button>
					</p>
			    </div>

  
  <div class="footer">&copy; 2020</div>
 </body>
</html>