<?php
require_once 'menu.inc.php';
require_once 'menuItem.inc.php';
class CMS {
	public $menus = array ();
	public $menuItems = array ();
	private $db_connection;
	private $db_handle;
	private $request;
	public function __construct() {

		$this->checkRequest ();
		
		$dbHost = "localhost";
		$dbUser = "***";
		$dbPW = "***";
		$dbname = "***";
		
		/*$con = mysql_connect ( $dbHost, $dbUser, $dbPW ) or die ( "Keine Verbindung zur Datenbank m�glich!" );
		$handle = mysql_select_db ( $dbname, $con ) or die ( "Konnte Datenbank nicht ausw�hlen!" );*/
		
		$this->db_connection = mysql_connect ( $dbHost, $dbUser, $dbPW ) or die ( "Keine Verbindung zur Datenbank m�glich!" );
		$this->db_handle = mysql_select_db ( $dbname, $this->db_connection ) or die ( "Konnte Datenbank nicht ausw�hlen!" );
	}
	public function __destruct() {
		mysql_close ( $this->db_connection );
	}
	public function readMenus() {
		$result = mysql_query ( "SELECT * FROM wawMenu", $this->db_connection );
		$i = 0;
		
		while ( $j = mysql_fetch_assoc ( $result ) ) {
			$temp = new menu ( $j ["ID"], $j ["name"] );
			$this->menus [$i] = $temp;
			$i ++;
		}
		;
	}
	public function readMenuItems() {
		$result = mysql_query ( "SELECT * FROM wawMenuItem", $this->db_connection );
		$i = 0;
		
		while ( $j = mysql_fetch_assoc ( $result ) ) {
			$temp = new menuItem ( $j ["ID"], $j ["name"], $j ["content"], $j ["parent"], $j ["head"], $j ["menuID"] );
			$this->menuItems [$i] = $temp;
			$i ++;
		}
	}
	public function writeMenu($menuName) {
		$menu;
		
		for($i = 0; $i < count ( $this->menus ); $i ++) {
			if ($menuName == $this->menus [$i]->name) {
				$menu = $this->menus [$i];
			}
		}
		
		for($i = 0; $i < count ( $this->menuItems ); $i ++) {
			$menuItem = $this->menuItems [$i];
			
			if ($menuItem->menuID == $menu->ID) {
				
				if ($menuItem->head == 1) {
					$this->buildDropdownMenu ( $menuItem, $menu );
				} else if ($menuItem->parent == "0" and $menuItem->head == 0) {
					$this->buildClassicMenu ( $menuItem );
				}
			}
		}
	}
	public function buildClassicMenu($menuItem) {
		if ($menuItem->ID == $this->request) {
			echo "<li class=\"active\"><a href=\"index.php?id=". $menuItem->ID . "\">" . $menuItem->name . "</a></li>";
		} else {
			echo "<li><a href=\"index.php?id=". $menuItem->ID . "\">" . $menuItem->name . "</a></li>";
		}
	}
	public function buildDropdownMenu($menuItem, $menu) {
		$active = "";
		
		if ($this->checkRequestDropdown ( $menuItem ) == true) {
			$active = " active";
		} 
		
		echo "<li class=\"dropdown". $active . "\">";
		echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"50\">" . $menuItem->name . "</a>";
		echo "<ul class=\"dropdown-menu\">";
		
		for($i = 0; $i < count ( $this->menuItems ); $i ++) {
			$dropMenuItem = $this->menuItems [$i];
			
			if ($dropMenuItem->menuID == $menu->ID and $dropMenuItem->parent == $menuItem->ID) {
				echo "<li><a href=\"index.php?id=". $dropMenuItem->ID . "\">" . $dropMenuItem->name . "</a></li>";
			}
		}
		
		echo "</ul></li>";
	}
	public function checkRequestDropdown($parent) {
		for($i = 0; $i < count ( $this->menuItems ); $i ++) {
			if ($this->menuItems [$i]->parent == $parent->ID and $this->menuItems [$i]->ID == $this->request) {
				return true;
			}
		} return false;
	}
	public function checkRequest() {
		if (! isset ( $_GET ["id"] ) or trim($_GET ["id"]) == "") {
			$this->request = "empty";
		} else {
			$this->request = (integer)$_GET ["id"];
		}
	}
	public function writeContent() {
		if ($this->request == "empty") {
			require_once 'start.inc.php';
			return;
		}
		
		$temp = $this->searchContent ();
		
		if ($temp == null) {
			require_once 'start.inc.php';
			return;
		}
		require_once $temp->content;
	}
	public function searchContent() {
		$temp;
		for($i = 0; $i < count ( $this->menuItems ); $i ++) {
			if ($this->menuItems [$i]->ID == $this->request) {
				$temp = $this->menuItems [$i];
				return $temp;
			}
		}
		
		return null;
	}
}

?>
