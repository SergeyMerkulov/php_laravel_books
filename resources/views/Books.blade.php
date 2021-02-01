<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Books</title>
	<link rel="stylesheet" type="text/css" href="<?php echo asset('css/style.css')?>">
	<style>
		#books {
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
			echo "<div id='del_alert' style='color: red; font-size: large; font-weight: 700; margin: 15px; opacity: 0; animation: hide_del 8s;'>";
			echo $done_message."</div>";
		}
		?>
	</nav>
	<main>
		<form id="goto_add_edit" action="add_edit_books" method="GET">
			<input type="submit" value=" + Add">
		</form>
		<form method='GET' action='show_books_with_filter'>
		<table border="2" bordercolor="black">
			<tr>
				<td>
					<select name='aut_id'>
						<?php
						if(isset($authors_list))
						{
							foreach ($authors_list as $author) 
							{		
								echo "<option value='".$author->id."' >".$author->name."</option>";
							}
						}
						?>
					<select>
					
				</td>
				<td>
					<input type='submit' value='apply'>
				</td>
			</tr>
		</table>
		</form>
		<table border="2" bordercolor="black">
			<tr>
				<td>
					id
				</td>
				<td>
					title
				</td>
				<td>
					authors
				</td>
				<td>
					date
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
		foreach ($books as $book) 
		{
			$id = $book->id;
			$title = $book->title;
			$date = $book->date;
			$selected_authors = "";
			echo "<tr>";
				echo "<td>";
					echo $id;
				echo "</td>";
				echo "<td>";
					echo $title;
				echo "</td>";
				echo "<td>";
					if(isset($authors[$counter]))
					{
						$key_first = true;
						foreach ($authors[$counter] as $author) 
						{
							echo $author->name."<br>";
							if(!$key_first)$selected_authors.=",";
							$selected_authors.=$author->id;
							$key_first = false;
						}
					}
				echo "</td>";
				echo "<td>";
					echo $date;
				echo "</td>";
				echo "<td>";
					echo "<form style='display: inline' method='GET' action='show_to_edit_book'>";
					echo "<input name='id' value='".$id."' type='hidden'>";
					echo "<input name='title' value='".$title."' type='hidden'>";
					echo "<input name='date' value='".$date."' type='hidden'>";
					//для выделения выбранных авторов
					echo "<input name='selected_authors' value='".$selected_authors."' type='hidden'>";
					echo "<input type='submit' value='edit'></form>";
				echo "</td>";
				echo "<td>";
					echo "<form style='display: inline' method='GET' action='del_book'>";
					echo "<input name='id' value='".$id."' type='hidden'>";
					echo "<input type='submit' value='delete'></form>";
				echo "</td>";
			echo "</tr>";
			$counter ++;
		}
		?>
		</table>
	</main>
</body>
</html>