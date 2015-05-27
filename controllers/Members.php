<?php

## -------------------------------------------------------
#  ADDICTIVE COMMUNITY
## -------------------------------------------------------
#  Created by Brunno Pleffken Hosti
#  http://github.com/brunnopleffken/addictive-community
#
#  File: Members.php
#  License: GPLv2
#  Copyright: (c) 2015 - Addictive Community
## -------------------------------------------------------

class Members extends Application
{
	/**
	 * --------------------------------------------------------------------
	 * MEMBER LIST
	 * --------------------------------------------------------------------
	 */
	public function Main()
	{
		$selected = "";
		$letter_list = "";

		// Yes. The alphabet...
		$letters = array(
			"a", "b", "c", "d", "e", "f",
			"g", "h", "i", "j", "k", "l",
			"m", "n", "o", "p", "q", "r",
			"s", "t", "u", "v", "w", "x",
			"y", "z"
		);

		// If there is a letter selected, don't let "All" selected
		if(Html::Request("letter")) {
			$first = "<a href='members'>" . i18n::Translate("M_ALL") . "</a>\n";
		}
		else {
			$first = "<a href='members' class='page-selected'>" . i18n::Translate("M_ALL") . "</a>\n";
		}

		// Build letter list
		foreach($letters as $value) {
			$label = strtoupper($value);

			$selected = (Html::Request("letter") == $value) ? "class='page-selected'" : "";
			$order = (Html::Request("order")) ? "&order=" . $_REQUEST['order']: "";

			$letter_list .= "<a href='members?letter={$value}{$order}' {$selected}>{$label}</a>\n";
		}

		// Get member list
		$results = $this->_GetMemberList();

		// Page info
		$page_info['title'] = i18n::Translate("M_TITLE");
		$page_info['bc'] = array(i18n::Translate("M_TITLE"));
		$this->Set("page_info", $page_info);

		// Return variables
		$this->Set("letter_first", $first);
		$this->Set("letter_list", $letter_list);
		$this->Set("results", $results);
	}

	/**
	 * --------------------------------------------------------------------
	 * GET MEMBER LIST
	 * --------------------------------------------------------------------
	 */
	private function _GetMemberList()
	{
		// Declare return variable
		$_result = array();

		// Sort by username, join date or number of posts
		if(Html::Request("order")) {
			switch(Html::Request("order")) {
				case "join":
					$order = "ORDER BY joined DESC";
					break;
				case "post":
					$order = "ORDER BY posts DESC";
					break;
			}
		}
		else {
			$order = "ORDER BY username";
		}

		// Search by username
		if(Html::Request("username")) {
			$username = Html::Request("username");
			$order = "WHERE username LIKE '%{$username}%' {$order};";
		}

		// Filter by first letter and execute query!
		if(Html::Request("letter")) {
			$letter = Html::Request("letter");
			$members = $this->Db->Query("SELECT * FROM c_members
					LEFT JOIN c_usergroups ON (c_members.usergroup = c_usergroups.g_id)
					WHERE username LIKE '{$letter}%' {$order};");
		}
		else {
			$members = $this->Db->Query("SELECT * FROM c_members
					LEFT JOIN c_usergroups ON (c_members.usergroup = c_usergroups.g_id)
					{$order};");
		}

		// Iterate between results
		while($result = $this->Db->Fetch($members)) {
			$result['avatar'] = $this->Core->GetGravatar($result['email'], $result['photo'], 72, $result['photo_type']);
			$result['joined'] = $this->Core->DateFormat($result['joined'], "short");
			$_result[] = $result;
		}

		return $_result;
	}
}
