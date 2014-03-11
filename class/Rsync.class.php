<?php

/**
 * Rsync同步类
 * 需要安装rsync ， 并配置rsync同步文件
 */
class Rsync {

	// 默认值，可以通过配置文件修改
	protected $RSYNC = "/usr/bin/rsync";

	// 初始化 , 检测RSYNC是否可用
	// 进入工程目录，检测工程是否初始化
	public function __construct() {
		$this -> RSYNC = C("RSYNC");
		if (!is_executable($this -> RSYNC)) {
			die("RSYNC is not executable!check you environment");
		}
	}

	public function rsync($path, $to) {
		$exclude = "";
		if (file_exists(".gitignore"))
			$exclude = "--exclude-from='.gitignore'";
		/**
		 * 参数解释
		 * -u 表示只进行更新 -a归档模式，表示以递归方式传输文件，并保持所有文件属性 -z压缩传输
		 */
		$RSYNC_HOST = C("RSYNC_HOST");
		$RSYNC_USER = C("RSYNC_USER");
		$RSYNC_PASSWORD = C("RSYNC_PASSWORD");
		$argvs = " -avuz --password-file=$RSYNC_PASSWORD $exclude $path $RSYNC_USER@$to";
		if (C("RSYNC_FULL")) {
			$argvs .= " --delete";
		}
		$cmd = $this -> RSYNC . $argvs;
		// return $cmd ; 
		exec($cmd, $rs, $status);
		if ($status) {
			return "rsync error: $cmd";
		} else {
			return $rs;
		}
	}

	/**
	 * 析构方法
	 */
	public function __destruct() {

	}

}
