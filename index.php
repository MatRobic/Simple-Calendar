<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Simple Calendar</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="datepicker/css/datepicker.css">
	<style>
		table {}
		th, td {text-align: center;}
		.gray {background-color: lightgray;}
		.yellow {background-color: yellow;}
		.blue {background-color: blue;}
	</style>
</head>
<body>
	
	<div class="container">
		<h1>Simple Calendar</h1>
		<p>Simple PHP page that can show a calendar that highlights last week of a picked date.</p>
		<div class="well">
			<form method='post' action='index.php'>
				<input class="datepicker control-form" type="text" name='date_picked' value='' placeholder="pick a date">
				<input class="btn btn-primary" type='submit' name='submit' value='Submit'/>
			</form>
		</div>
		<div class="row">
		<div class="calendar col-md-6">
				<?php 

				//This gets today's date 
				$date = time (); 

				$day = date('d', $date); 
				$date_piked_form = $day;
				if ( isset($_POST['date_picked']) ) {			    
					$date_piked_form = $_POST['date_picked'];
				}
				// $time = strtotime($date_piked_form);
				// $date_piked = date('d', $time);
				$date_piked = strtotime($date_piked_form);
				$dayOfTheWeek = date('N', $date_piked);	
				$date_piked_number = date('d', $date_piked);	
				$date_piked_month_number = date('n', $date_piked);				

				//This puts the day, month, and year in seperate variables 
				// $day = date('d', $date_piked);
				$month = date('m', $date_piked); 
				$year = date('Y', $date_piked);

				//Here we generate the first day of the month 
				$first_day = mktime(0,0,0,$month, 1, $year); 

				//This gets us the month name 
				$title = date('F', $first_day);

				//Here we find out what day of the week the first day of the month falls on 
				$day_of_week = date('D', $first_day); 

				//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
				switch($day_of_week) { 					
					case "Mon": $blank = 0; break; 
					case "Tue": $blank = 1; break; 
					case "Wed": $blank = 2; break; 
					case "Thu": $blank = 3; break; 
					case "Fri": $blank = 4; break; 
					case "Sat": $blank = 5; break; 
					case "Sun": $blank = 6; break; 
				}

				//We then determine how many days are in the current month
				$days_in_month = cal_days_in_month(0, $month, $year);

				//Here we start building the table heads 
				echo "<table class=\"table table-bordered\">";
				echo "<tr><th colspan=7> $title $year </th></tr>";
				echo "<tr><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td><td>Sun</td></tr>";

				//This counts the days in the week, up to 7
				$day_count = 1;
				echo "<tr>";

				//first we take care of those blank days
				while ( $blank > 0 ) { 
					echo "<td class=\"gray\"> </td>"; 
					$blank = $blank-1; 
					$day_count++;
				} 

				//sets the first day of the month to 1 
				$day_num = 1;			
				
				$stack = array();
				for ($i = 0; $i < 7; $i++) { 
					$number = $date_piked_number-$i-$dayOfTheWeek;
				    array_push($stack, $number);
				}			

				//count up the days, untill we've done all of them in the month
				while ( $day_num <= $days_in_month ) { 
					if ($day_num == $date_piked_number) {	
						echo "<td class=\"blue\">". $day_num ."</td>";
					}
					else {
						if (in_array($day_num, $stack)) {
							echo "<td class=\"yellow\">". $day_num ."</td>";
				    	} 
				    	else {    		
							echo "<td> $day_num </td>"; 
				    	}
					}
					$day_num++; 
					$day_count++;	
					//Make sure we start a new row every week
					if ($day_count > 7) {
						echo "</tr><tr>";
						$day_count = 1;
					}
				} 

				//Finaly we finish out the table with some blank details if needed
				while ( $day_count >1 && $day_count <=7 ) { 
					echo "<td class=\"gray\"></td>"; 
					$day_count++; 
				} 

				echo "</tr></table>";
				?>
			</div>
		</div>
		<div class="row">
			<h3>Credits</h3>
			<ul>
				<li><a href="https://github.com/Goatella/PHP-Calendar">https://github.com/Goatella/PHP-Calendar</a></li>
				<li><a href="http://www.eyecon.ro/bootstrap-datepicker">http://www.eyecon.ro/bootstrap-datepicker</a></li>
			</ul>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" src="datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">		
		$('.datepicker').datepicker();
	</script>
</body>
</html>