<?PHP

require_once 'common.php';

api();

function api() {
	$action = $_GET["action"];
	$projects_file = C("projects");
	
	$status = "" ; // 返回状态，用于给前端返回
	switch ($action) {
		case 'add' :
			$comment = $_GET["comment"];
			$status = $Git -> push();
			break;
		case 'del' :
			$Git -> init();
			break;
		case 'list' :
			$Git -> status();
			break;
		default :
			echo "action not define!";
			break;
	}
}
?>
