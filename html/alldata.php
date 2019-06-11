<html>
	<head>
		<title>Informations</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
 		<?php require_once 'navbar.php' ?>
	</head>
	<body>
		<br><center><h1 class="title is-1">Informations</h1></center><br>
		<center>
			<div class="box" box-background-black style="width: 820px; ">
				<article class="media">
					
					<div id="auto"></div>
					<script type="text/javascript">
						$(document).ready( function()
							{
							$('#auto').load('php/data.php');
							refresh();
							});
						 
						function refresh()
							{
							setTimeout( function()
								{
								$('#auto').load('php/data.php').fadeIn('slow');
								refresh();
								}, 5000);
							}	
					</script>
						  
				</article>
			</div>
		</center>	
	</body>
	<?php require_once 'footer.php' ?>
</html>
