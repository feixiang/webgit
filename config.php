<?php

$config = array(
	"DEBUG" => false
);

// git 全局参数配置
$git = array(
    'PROJECT_ROOT' => '/data2/www/yfcloud/',
    'GIT' => '/usr/bin/git',
    // projects xml file
    'projects' => "projects.xml",
);
// rsync 全局参数配置
$rsync = array(
	"RSYNC"=>"/usr/bin/rsync",
	"RSYNC_USER" => "webftp",
	"RSYNC_PASSWORD" => "/home/rsync.pwd",
	// 是否完全同步，即加入 --delete参数，保证文件完全一致 
	"RSYNC_FULL" => false
);

return array_merge($git , $rsync);

?>
