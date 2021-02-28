<?php
	include("header.php");
?>

<?php

		function feachDailyData(){

	    $url = "https://ltdemos.informatik.uni-hamburg.de/amsol/daily";

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CAINFO, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$server_output = curl_exec ($ch);

		//echo $server_output . " " . $url;die;
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    if (!$status  || !($status == 201 || $status == 200)) {

    		return "Nothing found";

		}
		else{
			$decoded = json_decode($server_output , true);



			$assoc = json_decode($decoded, true);
			$output =  "";
			foreach ($assoc as $key => $value) {
				foreach ($value as $key2 => $value2) {

					/*
					$output = $output . "<tr class='v-middle'><td>"
					.$key2
					."</td><td><span class='badge badge-primary text-uppercase'>"
					.$value2
					."</span></td></tr>";
					*/

					$speechKey = $value2;
					$speechTwitterId = $value2;
					if (($pos = strpos($value2, "_")) !== FALSE) {
                        $valueV = explode("_", $value2);

                        $speechKey = $valueV[0];
                        $speechTwitterId = $valueV[1];
                    }

					$output = $output . "<tr class='v-middle'><td>"
					."<a target='_blank' class='text-primary' href='https://twitter.com/anyuser/status/{$speechTwitterId}'>"
					.$key2
					."</a>"
					//."<td>"
					//."<a class='btn' href='https://ltdemos.informatik.uni-hamburg.de/amsol/translate/{$key2}'>Translate</a>"
					//."</td>"
					."</td><td><span class='badge badge-primary text-uppercase'>"
					.$speechKey;

					if(strcasecmp($speechKey, "hate") == 0){
					    $output =  $output . "</span></td><td onclick='changethumbsupcolor(this)' class='fa fa-thumbs-up fa-thumbs-up-hate'></td></tr>";

					}else if(strcasecmp($speechKey, "fake") == 0){
					    $output =  $output . "</span></td><td onclick='changethumbsupcolor(this)' class='fa fa-thumbs-up fa-thumbs-up-fake'></td></tr>";

					}else{
					    $output =  $output . "</span></td><td onclick='changethumbsupcolor(this)' class='fa fa-thumbs-up fa-thumbs-up-normal'></td></tr>";

					}

				}
			}


			return $output;
		}

	}
	?>

<script type="text/javascript">

			window.onload = function() {

			    //chartData();

			    //lineChartData();

	            $('#dailyInfoTable').DataTable( {"order": []} );

	            //$('#factCheckerTable').DataTable();
			}
</script>
</head>
<body>
	<div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar">
			<div class="p-4 pt-5">
				<a href="home.php" class="img logo rounded-circle mb-5" style="background-image: url(selam.png);"></a>
		<?php

					include("sidemenu.php");
				?>
				<div class="footer">
					<p>
					Copyright ©2021 All rights reserved
					</p>
				</div>
			</div>
		</nav>

		<div id="content" class="p-4 p-md-5">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
						<i class="fa fa-bars"></i>
						<span class="sr-only">Toggle Menu</span>
					</button>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars"></i>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<?php
							include("mainmenu.php");
						?>
					</div>
				</div>
			</nav>
			<h2 class="mb-4">Daily Info</h2>
			<p class="text-body">
			    Daily info is an infobox that gives an analysis of tweets published on the <kbd>current</kbd> day. It analyzes the tweet based on simple text analysis techniques such as filter using keywords to label the tweet as <kbd>hate</kbd>, <kbd>fake</kbd> or <kbd>fact</kbd> related. The labels are not verified by experts. The suggestions are purely based on query or keyword matching and an AI component is in the planning.
			</p>
			<p>

			    <table id="dailyInfoTable" class="table table-theme table-row v-middle">
                <thead>
                    <tr>
                        <th class="text-muted">Sentence</th>
                        <th class="text-muted">Labble</th>
                        <th class="text-muted"></th>
                    </tr>
                </thead>
                <tbody>
							<?php

		                        echo feachDailyData();

							?>
							</tbody>
            </table>
			</p>
		</div>
	</div>
	<?php
		include("scripts.php");
	?>

</body></html>
