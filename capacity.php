<?php

$username = 'jira_username';
$password = 'jira_password';
$jira_domain = 'your_jira_url'; // base domain, ie: https://mycompany.atlassian.net

/*
*	$board_ids is an array of key/value pairs
*		where key is the label you want to display (typically the board name for clarity),
*		and the value is the id of the Jira Board (typically this is the rapidViewId in the URL when viewing the board online).
*
*	ex:
*		$board_ids = array(
*			'Dev' => 13,
*			'QA' => 8,
*			'ProjectA' => 5
*		);
*/

$board_ids = array();
asort($board_ids);

$t = time();
$url = "{$jira_domain}/rest/greenhopper/1.0/xboard/work/allData.json?rapidViewId=";

$context = stream_context_create(array(
    'http' => array(
        'header'  => "Authorization: Basic " . base64_encode("$username:$password")
    )
));

$boards = array();
foreach ( $board_ids AS $label => $id )
{
	$board_url = $url.$id;
	$response = file_get_contents( $board_url, false, $context );

	$data = json_decode($response);

	$boards[$label]['status'] = 'green';

	foreach( $data->columnsData->columns AS $column )
	{
		$value = $column->statisticsFieldValue;
		$max = (int) $column->max;

		if ( $max && $value > $max )
		{
			$boards[$label]['status'] = 'red';
			$boards[$label]['cols'][] = $column->name;
		}
	}
}


?><html>
<head>
<title>Jira Board Capacity</title>
<style>
body {
	background: black;
	color: white;
	margin:0;
	padding:0;
	font-family: helvetica;
	position: relative;
}
.status {
	text-align: center;
	position:relative;
	color:#fefefe;
	float:left;
	width:23%;
	min-height:33px;
	overflow:hidden;
	padding:2px 0;
	background-color: #858585;
	margin:5px 1% 10px 1%;
}
.status .cols
{
	font-size:smaller;
}
.green { background-color: #008B00; }
.red { background-color: #FF3030; }
#lastupdate {
	color:#fff;
	clear:both;
	text-align: center;
	font-size:12px;
	font-family: helvetica;
}

</style>
</head>
<body>
<div id="lastupdate">Last updated: <?php echo date('m/d/Y g:i:s a') ?> in <?php echo time() - $t; ?> seconds</div>
<?php
foreach ( $boards AS $label => $status )
{
	?>
	<div class='status <?php echo $status['status']; ?>'>
		<?php
		echo $label;

		if ( !empty( $status['cols'] ) ) { ?>
		<div class="cols">
			"<?php echo implode( '", "', $status['cols'] ); ?>"
		</div>
		<?php } ?>
	</div>
	<?php
}
?>
</body>
</html>

