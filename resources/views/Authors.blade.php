<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Authors</title>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('css/style.css')?>">
	<style>
		#authors {
			background-color: #fff;
			border-top: 2px #000 solid;
			border-left: 2px #000 solid;
			border-right: 2px #000 solid;
			border-bottom: 2px #fff solid;
		}
		td {
			padding: 10px;
		}
		#goto_add_edit {
			margin: 15px;
		}
		#goto_add_edit input {
			padding: 8px;
		}
		main {
			margin-left: 20px;
		}
		table tr:first-child {
			font-weight: bold;
			font-size: large;
		}
	</style>
</head>
<body>
	<nav>
		<a id="books" href="books">books</a>
		<a id="authors" href="authors">authors</a>
		<?php
		if(isset($done_message))
		{
			echo "<style> @keyframes hide_del { from {opacity: 1;} to {opacity: 0;} } </style>";
			echo "<div id='del_alert' style='color: red; font-size: large; font-weight: 700; margin: 15px; opacity: 0; animation: hide_del 5s;'>";
			echo $done_message."</div>";
		}
		?>
	</nav>
	<main>
		<form id="goto_add_edit" action="add_edit_authors" method="GET">
			<input type="submit" value=" + Add">
		</form>
		<table border="2" bordercolor="black">
		<tr>
			<td>
				id
			</td>
			<td>
				name
			</td>
			<td>
				books number
			</td>
			<td>
				edit
			</td>
			<td>
				delete
			</td>
		</tr>
		<?php
		$counter = 0;
		foreach ($authors as $author) 
		{
			$id = $author->id;
			$name = $author->name;
			
			echo "<tr>";
				echo "<td>";
					echo $id;
				echo "</td>";
				echo "<td>";
					echo $name;
				echo "</td>";
				echo "<td>";
					echo $books_numbers[$counter];
				echo "</td>";
				echo "<td>";
					echo "<form style='display: inline' method='GET' action='add_edit_authors'><input name='id' value='".$id."' type='hidden'>";
					echo "<input type='submit' value='edit'></form>";
				echo "</td>";
				echo "<td>";
					echo "<form style='display: inline' method='GET' action='del_author'><input name='id' value='".$id."' type='hidden'>";
					echo "<input type='submit' value='delete'></form>";
				echo "</td>";
			echo "</tr>";
			$counter++;
		}
		?>
		</table>
	</main>
</body>
</html>