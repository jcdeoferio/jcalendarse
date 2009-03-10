<?php
class Rss extends Controller{
	function Rss(){
		parent::Controller();
		$this->load->model('User');
		$this->load->model('JCalendar');
		$this->load->library('pagination');
		$this->load->helper('string');
	}
	function index(){
		redirect('rss/getfeed/');
	}
	function getfeed($feed = null){
		if($feed == null){
			$events = $this->JCalendar->select_all_events(-1);
			$data['events'] = $events;
			$this->load->view('feeds/rss', $data);
		}else{
			$userid = $this->db->query("SELECT userid from userdetails WHERE rssfeed = '".$feed."'")->row_array();
			$userid = $userid['userid'];
			$events = $this->JCalendar->select_all_events($userid);
			$data['events'] = $events;
			$data['feed'] = $feed;
			$this->load->view('feeds/rss', $data);
		}
	}
}
?>