<html>
<head>
	<style>
	body {
		padding:0;
		margin:0;
	}

	iframe {
		border:0;
		background-color:black;
		color:white;
		text-align: center;
	}

	</style>
</head>
<body>
<iframe id="capacity" src="capacity.php" width="100%" height="100%"></iframe>
<script>
setInterval(function(){
	document.getElementById("capacity").src="capacity.php";
}, 300000);
</script>
</body>
</html>
