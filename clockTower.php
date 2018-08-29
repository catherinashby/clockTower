<?php
/**
 *  A clock tower will ring its bell every hour, on the hour, a number of
 *  times equal to the number indicated by the hour hand.
*/
class ClockTower
{
 /**
  * Count the total bells that are rung between two times.
  *
  * If either time is 'on the hour', the count will include that hour's bells.
  * If both times are equal, assume a full twenty-four hours, not zero.
  *
  * @param string $t1  start time; format hh:mm (24-hr clock)
  * @param string $t2    end time; format hh:mm (24-hr clock)
  *
  * @return integer
  *
  */
    public function countBells( $t1, $t2 ) {
	    $bells = 0;
		$a1 = sscanf( $t1, "%d:%d", $h1, $m1 );
		if ( $a1 !== 2 )		#	error on scan
			return 0;
		//	adjust time, if needed
		while ( $m1 > 59 ):
			$h1 += 1;
			$m1 -= 60;
		endwhile;
		while ( $h1 > 23 ):
			$h1 -= 24;
		endwhile;
		//
		$a2 = sscanf( $t2, "%d:%d", $h2, $m2 );
		if ( $a2 !== 2 )		#	error on scan
			return 0;
		//	adjust time, if needed
		while ( $m2 > 59 ):
			$h2 += 1;
			$m2 -= 60;
		endwhile;
		while ( $h2 > 23 ):
			$h2 -= 24;
		endwhile;
		//
		//	test for matching times
		if ( ( $h1 == $h2 ) && ( $m1 == $m2 ) )
			{
			$bells = 156;
			if ( $m1 > 0 )
				return $bells;
			}
;		//
		// advance start time to first 'chime'
		if ( $m1 > 0 )
			$h1 += 1;
		//
		//	once around the (24-hr) clock
		while ( $h1 != $h2 ):
			$rings = $h1 % 12;
			if ( $rings == 0 )
				$rings = 12;
			$bells += $rings;
			$h1 += 1;
			if ( $h1 > 23 )
				$h1 -= 24;
		endwhile;
		//	and once more, for the final 'fencepost'
		$rings = $h1 % 12;
		if ( $rings == 0 )
			$rings = 12;
		$bells += $rings;
		return $bells;
	}
}
 ?>
<html>
<head>
  <title>Clock Tower</title>
  <meta http-equiv="Expires" content="<?php echo date( "c", 300 + time() ); ?>" >
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
  <meta http-equiv="content-script-type" content="text/javascript" />
  <style>
	ul	{ list-style: none; }
	span.lbl	{  display: inline-block; min-width: 4em;
					text-align: right; padding: 0.25em; }
	input.txt	{ width: 7em; }
  </style>
  <script>
  </script>
</head>
<body>
<?php
$timeBegin = "";
$timeEnd = "";
if ( array_key_exists( 'timeBegin', $_POST ) ) {
	$timeBegin = $_POST[ 'timeBegin' ]; }
if ( array_key_exists( 'timeEnd', $_POST ) ) {
	$timeEnd = $_POST[ 'timeEnd' ]; }
//
$tower = new ClockTower();
$b = $tower->countBells( $timeBegin, $timeEnd );
 ?>
  <p>
  Enter start and end times in HH:MM format (24-hour clock).
  </p>
  <form action="" method="POST">
    <ul>
	  <li>
	    <span class="lbl">From:</span>
		<input class="txt" name="timeBegin" required value="<?php echo $timeBegin ?>" />
	  </li>
	  <li>
	    <span class="lbl">To:</span>
		<input class="txt" name="timeEnd" required value="<?php echo $timeEnd ?>" />
	  </li>
	  <li>
		<span class="lbl"> </span>
		<input type="submit" value="Go!" />
	  </li>
	  <li><?php
	  if ( $b > 0 ) {
		  $ess = "s";
		  if ( $b == 1 ) {
			  $ess = "";
		  }
		  echo "The clock will chime {$b} time{$ess}.";
	  }
		?>
	  </li>
	</ul>
  </form>
</body>
</html>