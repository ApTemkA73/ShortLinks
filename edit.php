<?php 
	require 'db.php';
	 if (!isset ($_SESSION['logged_user']) ){
	 header('Location: index.php');}
	 if(isset($_GET['id'])){
		$link = $_GET['id'];
		$searhlink = R::findOne ('links', "linkout = ?", ["$link"]);
		if($searhlink){
			$requst = $searhlink['linkin'];
		}
		else
		{
			$requst = 'Ссылка которую вы хотите сократить не существует.';
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
						"oldlink":    '<?php echo $link; ?>',
                    },
                    
                    success: function(otvet)
					{
						$('.messages').html(otvet.result);
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
				<h2>Редактирование ссылки</h2>
					<p>
						Ваша ссылка:<br/>
						<input type="text" id="link" value="<?php echo $requst; ?>" /><br/>
						<input type="button" value="Сохранить" id="btn_submit" />  
						<div class="messages">
						</div>
					</p>
			    </div>

  
  <div class="footer">&copy; 2020</div>
 </body>
</html>
