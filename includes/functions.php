<?php
	// This file is the place to store all basic functions

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: ");
		}
	}
	
	function get_all_subjects() {
		global $connection;
		$query = "SELECT * 
				FROM subjects 
				ORDER BY position ASC";
		$subject_set = mysqli_query( $connection,$query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function get_pages_for_subject($subject_id) {
		global $connection;
		$query = "SELECT * 
				FROM pages 
				WHERE subject_id = {$subject_id} 
				ORDER BY position ASC";
		$page_set = mysqli_query( $connection,$query);
		confirm_query($page_set);
		return $page_set;
	}

	function get_subject_by_id($subject_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query( $connection,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		$subject = mysqli_fetch_array($result_set);
		return $subject;
		
	}

	function get_page_by_id($page_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=" . $page_id ." ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query( $connection,$query);
		confirm_query($result_set);
		// REMEMBER:
		// if no rows are returned, fetch_array will return false
		$page = mysqli_fetch_array($result_set);
		return $page;
	}

	function find_selected_page(){
		global $sel_subject;
		global $sel_page;
		if (isset($_GET['subj'])) {
			$sel_subject = get_subject_by_id($_GET['subj']);
			
			$sel_page = NULL;
		} elseif (isset($_GET['page'])) {
			$sel_subject = NULL;
			$sel_page = get_page_by_id($_GET['page']);
		} else {
			$sel_subject = NULL;
			$sel_page = NULL;
		}
	}

	function navigation($sel_subject, $sel_page){
		echo "<ul class=\"subjects\">";
		$subject_set = get_all_subjects();
		while ($subject = mysqli_fetch_array($subject_set)) {
			echo "<li";
			if(isset($sel_subject)) if ($subject["id"] == $sel_subject['id']) { echo " class=\"selected\""; }
			
			echo "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			$page_set = get_pages_for_subject($subject["id"]);
			echo "<ul class=\"pages\">";
			while ($page = mysqli_fetch_array($page_set)) {
				echo "<li";
				if(isset($sel_page)) if ($page["id"] == $sel_page['id']) { echo " class=\"selected\""; }
				echo "><a href=\"content.php?page=" . urlencode($page["id"]) .
					"\">{$page["menu_name"]}</a></li>";
			}
			echo "</ul>";
		}

		echo 	"</ul>";
	}

	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
?>