<?PHP

require_once 'common.php';

api();

function api() {
	$action = $_GET["action"];
	$project = C("PROJECT_ROOT") . $_GET["project"];
	chdir($project) or die("chdir $project error");

	$Git = new Git();
	$message = "";
	switch ($action) {
		case 'push' :
			$comment = $_GET["comment"];
			$origin = $_GET["origin"];
			$message = $Git -> push($comment);
			break;
		case 'status' :
			$message = $Git -> status();
			break;
		case 'rsync' :
			$RSYNC = new Rsync();
			$rsync_from = $project;
			$rsync_to = $_GET["path"];
			$message = $RSYNC -> rsync($rsync_from, $rsync_to);
			break;
		case 'tag' :
			$tag = $_GET["tag"];
			$message = $Git -> tag();
			break;
		case 'reset' :
			$message = $Git -> reset();
			break;
		case 'reset_hard' :
			$message = $Git -> reset_hard();
			break;
		case 'init' :
			$origin = $_GET["origin"];
			$message = $Git -> init($origin);
			break;

		default :
			$message = "action not define!";
			break;
	}
	ajaxReturn(null, web_format($message), 1);
}
?>
