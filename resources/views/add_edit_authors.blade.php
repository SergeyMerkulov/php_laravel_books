<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add/edit books</title>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('css/style.css')?>">
	<style>
		#add_edit_authors {
			background-color: #fff;
			border-top: 2px #000 solid;
			border-left: 2px #000 solid;
			border-right: 2px #000 solid;
			border-bottom: 2px #fff solid;
		}
		form {
			padding: 15px;
			margin: 15px;
		}
		form input[type="submit"] {
			padding: 8px;
			margin: 8px;
		}
	</style>
</head>
<body>
	<nav>
		<a id="books" href="books">books</a>
		<a id="authors" href="authors">authors</a>
	</nav>
	@if (count($errors) > 0)
	<style>
		input[type="text"] {
			border: 2px solid red;
		}
	</style>
	@endif
	<main>
		<?php
			if( isset($done) )
			{
				echo $done;
			}
			else
			{
				if( isset($name) && isset($id) )
				{
					echo "<form method='GET'  action='edit_author'>";
					echo "<input type='hidden' name='id' value='".$id."'>";
					echo "The author name is:<input type='text' name='name' size='40' value='".$name."'>";
					echo "<br><input type='submit' value='save' >";
				}
				else
				{
					echo "<form method='GET'  action='add_author'>";
					echo "The author name is:<input type='text' name='name' size='40'>";
					echo "<br><input type='submit' value='add' >";
				}
			}
		?>
	@if (count($errors) > 0)
	<div style="color: red">
	<h3>Error</h3>
    <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
	</div>
	@endif	
	</main>
</body>
</html>