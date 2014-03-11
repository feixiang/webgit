<?php

/**
 * Git操作类
 */
class Git {

	// 数据库连接ID 支持多个连接
	protected $GIT = "/usr/bin/git";

	// 初始化 , 检测git是否可用
	// 进入工程目录，检测工程是否初始化
	public function __construct() {
		$this -> GIT = C("GIT");
		if (!is_executable($this -> GIT)) {
			die("Git is not executable!check you environment");
		}
	}

	/**
	 * 返回状态结果
	 */
	public function status() {
		$cmd = $this -> GIT . " status";
		exec($cmd, $rs, $status);
		return $rs;
	}

	public function push($comment = "", $origin = "") {
		// 2013年10月11日 修改为 git add . ，因为git add *会把忽略的文件也加进去
		$cmd = $this -> GIT . " add .";
		exec($cmd, $rs, $status);
		if ($status) {
			return "add error";
		}
		//确认提交用户名
		$cmd = $this -> GIT . " config user.name 'WebUser'";
		exec($cmd, $rs, $status);
		if ($status) {
			return "set user.name error: $cmd";
		}
		$cmd = $this -> GIT . " config user.email 'WebUser@server.com'";
		exec($cmd, $rs, $status);
		if ($status) {
			return "set user.email error: $cmd";
		}
		// 去掉文件属性更改
		$cmd = $this -> GIT . " config core.filemode false";
		exec($cmd, $rs, $status);
		if ($status) {
			return "set file mode error : $cmd";
		}
		$cmd = $this -> GIT . " commit -a -m \"$comment\"";
		exec($cmd, $rs, $status);
		if ($status) {
			return "commit error : $cmd";
		}
		
		// 根据前端提交的origin，重新设置
		$this->set_url($origin);
		
		// 强制覆盖提交
		$cmd = $this -> GIT . " push -f origin master --tags";
		// echo $cmd ;
		exec($cmd, $rs, $status);
		if ($status) {
			return "push error : $cmd";
		}
		return $rs;
	}

	//提交标签
	public function tag($tag) {
		$cmd = $this -> GIT . " tag $tag";
		exec($cmd, $rs, $status);
		return $status == 0 ? 1 : 0;
	}

	//回退版本
	public function reset() {
		$cmd = $this -> GIT . " reset HEAD^";
		exec($cmd, $rs, $status);
		return $status == 0 ? 1 : 0;
	}

	//强制代码回退
	public function reset_hard() {
		$cmd = $this -> GIT . " reset --hard HEAD^";
		exec($cmd, $rs, $status);
		return $status;
	}

	// 初始化版本库
	// 参数： origin - 远程仓库地址
	public function init($origin) {
		$cmd = $this -> GIT . " init";
		exec($cmd, $rs, $status);
		//添加remote origin
		$cmd = $this -> GIT . " remote add origin $origin";
		exec($cmd, $rs, $status);
		//去掉文件属性更改
		$cmd = $this -> GIT . " config core.filemode false";
		exec($cmd, $rs, $status);
		return $status;
	}

	// 设置提交的url
	public function set_url($origin) {
		$cmd = $this -> GIT . " remote set-url origin $origin";
		exec($cmd, $rs, $status);
		return $status;
	}

	// 判断是否git已经建立
	protected function isgit() {
		return file_exists(".git");
	}

	/**
	 * 析构方法
	 */
	public function __destruct() {

	}

}
