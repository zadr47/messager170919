<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>check_in</title>
</head>
<body>
	Выберите вопрос и ответьте на него.	
	<div id = "message">
	<?php if(!empty($message)):	
			
		echo "<p>$message</p>";

	endif;?>
	<form action="/secret_question.php">
		<p><input type="radio" name="question" value="school_my_mather">Первая школа в которой училась мама?</p>
		<p><input type="radio" name="question" value="school_my_father">Первая школа в которой учился отец?</p>
		<p><input type="radio" name="question" value="mom_last_name">Девичья фамилия мамы?</p>
		<p><input type="radio" name="question" value="grandmother_year_of_birth">Год рождения бабушки?</p>
		<p><input type="radio" name="question" value="grandfather_year_of_birth">Год рождения дедушки?</p>
		<p><input type="radio" name="question" value="name_of_favorite_pet">Имя любимого питомца?</p>
		<p><input type="radio" name="question" value="date_of_first_sex">Дата первого секса?</p>
		<p><input type="text" name="answer" placeholder="Ответ"></p>		
		<p><input type="submit" name="do_question" value="Ответить"></p>
	</form>
</body>
</html>