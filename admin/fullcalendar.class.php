<?php
class Fullcalendar
{

	// private $host = '172.20.250.202'; //ชื่อ Host 
	// private $user = 'sa'; //ชื่อผู้ใช้งาน ฐานข้อมูล
	// private $password = 'wangchao27443'; // password สำหรับเข้าจัดการฐานข้อมูล
	// private $database = 'wasadu'; //ชื่อ ฐานข้อมูล

	private $host = 'localhost'; //ชื่อ Host 
	private $user = 'root'; //ชื่อผู้ใช้งาน ฐานข้อมูล
	private $password = ''; // password สำหรับเข้าจัดการฐานข้อมูล
	private $database = 'wasadu'; //ชื่อ ฐานข้อมูล

	//function เชื่อมต่อฐานข้อมูล
	protected function connect()
	{

		$mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

		$mysqli->set_charset("utf8");

		if ($mysqli->connect_error) {

			die('Connect Error: ' . $mysqli->connect_error);
		}

		return $mysqli;
	}

	//function show data in fullcalendar
	public function get_fullcalendar()
	{

		$db = $this->connect();
		$get_calendar = $db->query("SELECT * FROM calendar");

		while ($calendar = $get_calendar->fetch_assoc()) {
			$result[] = $calendar;
		}

		if (!empty($result)) {

			return $result;
		}
	}

	//show data in modal
	public function get_fullcalendar_id($get_id)
	{

		$db = $this->connect();
		$get_user = $db->prepare("SELECT id,title,start,end FROM calendar WHERE id = ?");
		$get_user->bind_param('i', $get_id);
		$get_user->execute();
		$get_user->bind_result($id, $title, $start, $end);
		$get_user->fetch();

		$result = array(
			'id' => $id,
			'title' => $title,
			'start' => $start,
			'end' => $end
		);

		return $result;
	}

	//save new data 
	public function new_calendar($data)
	{

		$db = $this->connect();

		$add_user = $db->prepare("INSERT INTO calendar (id,title,start,end) VALUES(NULL,?,?,?) ");

		$add_user->bind_param("sss", $data['title'], $data['start'], $data['end']);

		if (!$add_user->execute()) {

			echo $db->error;
		} else {

			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}

	//edit data 
	public function edit_calendar($data)
	{

		$db = $this->connect();

		$add_user = $db->prepare("UPDATE calendar SET title = ? , start = ? ,end = ? WHERE id = ?");

		$add_user->bind_param("sssi", $data['title'], $data['start'], $data['end'], $data['edit_calendar_id']);

		if (!$add_user->execute()) {

			echo $db->error;
		} else {

			echo "บันทึกข้อมูลเรียบร้อย";
		}
	}

	//delete data
	public function del_calendar($id)
	{

		$db = $this->connect();

		$del_user = $db->prepare("DELETE FROM calendar WHERE id = ?");

		$del_user->bind_param("i", $id);

		if (!$del_user->execute()) {

			echo $db->error;
		} else {

			echo "ลบข้อมูลเรียบร้อย";
		}
	}
}
