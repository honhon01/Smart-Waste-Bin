<?php
	$servername = "localhost";
	$username = "wastebin";
	$password = "wastebin";
	$databasename = "waste_bin";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $databasename);			
?>
<center>
	<table class="table is-hoverable is-striped ">
		
		<thead>
			<tr>
				<th><center>Time</center></th>
				<th><center>Temperature (°C)</center></th>
				<th><center>Humidity (%)</center></th>
				<th><center>Level (%)</th></center>
				<th><center>Moisture</center></th>
				<th><center>Usage</center></th>
			</tr>
		</thead>
		<tbody>
		
			<?php
				$sql = "SELECT * FROM binData ORDER BY time DESC LIMIT 24";
				$result = $conn->query($sql);

				while($row = $result->fetch_assoc())
					{
					echo(	"<tr>
							<td><center>" .$row["time"]. "</center></td>
							<td><center>". $row["temp"]. "</center></td>
							<td><center>". $row["humid"]. "</center></td>
							<td><center>" . $row["lvl"] . "</center></td>
							<td><center>" . $row["mois"] . "</center></td>
							<td><center>" . $row["opn"] . "</center></td>
							</tr>");
					}
				$conn->close();
			?>
		
		</tbody>
	</table>
	<div id="tablediscribe">
		<p class="is-size-7">Recent 24 data shown.</p>
	</div>
</center>

