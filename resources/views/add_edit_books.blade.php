<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add/edit books</title>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('css/style.css')?>">
	<style>
		#add_edit_books {
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
		form input {
			margin: 8px;
		}
		form input[type="submit"] {
			padding: 8px;
		}
	</style>
</head>
<body>
	<nav>
		<a id="books" href="books">books</a>
		<a id="authors" href="authors">authors</a>
		<?php
		if(isset($done))
		{
			echo "<style> @keyframes hide_del { from {opacity: 1;} to {opacity: 0;} } </style>";
			echo "<div id='del_alert' style='color: red; font-size: large; font-weight: 700; margin: 15px; opacity: 0; animation: hide_del 8s;'>";
			echo $done."</div>";
		}
		?>
	</nav>
	<main>
		@if(count($errors->get('book_title'))>0)
		<style>
			form input[name='book_title'] {
				border: 2px solid red;
			}
		</style>
		@endif
		@if(count($errors->get('book_date'))>0)
		<style>
			form input[name='book_date'] {
				border: 2px solid red;
			}
		</style>
		@endif
		@if(count($errors->get('authors'))>0)
		<style>
			form select {
				border: 2px solid red;
			}
		</style>
		@endif
		<?php
		if( isset($id) && isset($title) && isset($date) )
		{
			echo "<form method='GET' action='edit_book' >";
			echo "edit book id=".$id."<br>";
			echo "<input name='id' value='".$id."' type='hidden'>";
			echo "<table><tr><td>book title:</td><td><input type='text' name='book_title' value='".$title."'></td></tr>";
			echo "<tr><td>date:</td><td><input type='text' name='book_date' value='".$date."'></td></tr></table>";
			echo "authors:<br><select multiple size='4' name='authors[]'>";
			$counter = 0;
				if(isset($authors))
				{
					if( isset($selected_authors) )
					{
						foreach ($authors as $author) 
						{	
							$counter ++;
							if( in_array( $author->id, $selected_authors )  )
							{
								echo "<option selected value='".$author->id."'>".$author->name."</option>";
							}
							else
							{
								echo "<option value='".$author->id."'>".$author->name."</option>";
							}
						}
					}
					else
					{
						foreach ($authors as $author) 
						{	
							$counter ++;
							echo "<option value='".$author->id."'>".$author->name."</option>";
						}
					}
				}
			echo "</select><br><input type='submit' value='save' ></form>";
		}
		else
		{
			echo "<form method='GET' action='add_book' >";
			echo "<table><tr><td>book title:</td><td><input type='text' name='book_title'></td></tr>";
			echo "<tr><td>date:</td><td><input type='text' name='book_date'></td></tr></table>";
			echo "authors:<br><select multiple size='4' name='authors[]'>";
			$counter = 0;
			if(isset($authors))
			{
				foreach ($authors as $author) 
				{	
					$counter ++;
					echo "<option value='".$author->id."'>".$author->name."</option>";
				}
			}
			echo "</select><br><input type='submit' value='add' ></form>";
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