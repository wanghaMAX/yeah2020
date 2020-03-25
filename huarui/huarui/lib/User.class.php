<?php
/**
 * 会员类
 * @author 马银华　QQ:9986584
 * @version 1.0
 */
class User {
	
	public $uid = 0;
	
	public $username = '';
	
	/**
	 * 状态有效
	 */
	const USER_STATE_YES = 1;
	
	/**
	 * 状态无效
	 */
	const USER_STATE_NO = 0;
	
	
	public $userState = array(
	                         self::USER_STATE_NO    =>   '无效',
	                         self::USER_STATE_YES   =>   '有效'
	                    );
	
	function __construct() {
		$this->uid = isset($_SESSION['uid'])?$_SESSION['uid']:0;
		$this->username = isset($_SESSION['username'])?$_SESSION['username']:'';
	
	}
	
	/**
	 * 获取登录用户id
	 */
	public function getUid(){
		return $this->uid;
	}
	
	/**
	 * 获取登录的用户名
	 */
	public function getUsername(){
		return $this->username;
	}
	
	/**
	 * 添加用户
	 */
	public function addUser($form){
		$data = array(
		           'username'   =>    trim($form['username']),
		           'password'   =>    str::md99($form['password']),
                   'email'      =>    $form['email'],
		           'state'      =>    isset($this->userState[$form['state']])?$form['state']:self::USER_STATE_NO
		        );
		 if(Db::open()->insert('aboc_user',$data))
		 return true;
		 else
		 return false;
	}
	
	/**
	 * 编辑用户
	 *
	 */
	public function editUser($uid,$form){
		$uid = intval($uid);
		$data = array(
		           'email'      =>    $form['email'],
		           'state'      =>    isset($this->userState[$form['state']])?$form['state']:self::USER_STATE_NO
		        );
		 if(Db::open()->update('aboc_user',$data,'uid='.$uid))
		 return true;
		 else 
		 return false;
		
	}

	/**
	 * 修改密码
	 *
	 */
	public function editPassword($uid,$password){
		$uid = intval($uid);
		$data = array('password'=>str::md99($password));
		 if(Db::open()->update('aboc_user',$data,'uid='.$uid))
		 return true;
		 else 
		 return false;		
	}
	
	
	/**
	 * 删除用户
	 */
	public function delUser($uid){
		$uid = intval($uid);
		if( Db::open()->delete('aboc_user','uid='.$uid) )
		return true;
		else 
		return false;
	}
	
	/**
	 * 获取用户信息
	 */
	public function getUserInfo($uid,$isUid=true){
		if($isUid)
		$where = 'uid='.intval($uid);
		else
		$where = "username='".trim($uid)."'";
		$sql = "select * from aboc_user where $where limit 1";
		return Db::open()->fetchRow($sql);
	}
	
	/**
	 * 判断用户名和密码，并更新session
	 */
	public function checkUser($username,$password){
		$info = $this->getUserInfo($username,0);
		//用户名不存在
		if(empty($info))return -1;
		//密码不正确
		if(str::md99($password)!=$info['password'])return -2;
		//用户已被禁用
		if($info['state'] == self::USER_STATE_NO)return -3;
		$_SESSION['uid'] = $info['uid'];
		$_SESSION['username'] = $info['username'];
		//正确
		return $info['uid'];
	}
	
	/**
	 * 判断是否登录
	 */
	public function isLogin(){
		return $this->uid;
	}
	
	/**
	 * 获取管理员列表
	 */
	public function getUserList(){
		$sql = "select * from aboc_user order by uid";
		return Db::open()->fetchAll($sql);
	}
	
	function __destruct() {
	    
	}
}

?>