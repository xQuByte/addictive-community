<?php

## -------------------------------------------------------
#  ADDICTIVE COMMUNITY
## -------------------------------------------------------
#  Created by Brunno Pleffken Hosti
#  https://github.com/addictivehub/addictive-community
#
#  File: Admin.php
#  License: GPLv2
#  Copyright: (c) 2017 - Addictive Community
## -------------------------------------------------------

namespace AC\Kernel;

class Admin
{
	/**
	 * --------------------------------------------------------------------
	 * ADMIN CONSTRUCTOR
	 * --------------------------------------------------------------------
	 */
	public function __construct()
	{
		// ...
	}

	/**
	 * --------------------------------------------------------------------
	 * SHOW CONFIGURATION INSIDE AN INPUT[TEXT] OR TEXTAREA FIELD
	 * --------------------------------------------------------------------
	 */
	public function selectConfig($field_name)
	{
		Database::query("SELECT value FROM c_config WHERE field = '{$field_name}';");
		$fetch = Database::fetch();

		if($fetch['value']) {
			return $fetch['value'];
		}
		else {
			return false;
		}
	}

	/**
	 * --------------------------------------------------------------------
	 * AUTOMATIC DROP-DOWN (<SELECT> TAG)
	 * --------------------------------------------------------------------
	 * $options = array("key" => 0, "value" => "")
	 */
	public function selectField($field_name, $options, $value = "", $class = "")
	{
		$str = "<select name='{$field_name}' class='form-control {$class}'>";

		foreach($options as $k => $v) {
			$selected = ($k == $value) ? "selected" : "";
			$str .= "<option value='{$k}' {$selected}>{$v}</option>";
		}

		$str .= "</select>";

		return $str;
	}

	/**
	 * --------------------------------------------------------------------
	 * IF 1, THEN CHECKBOX IS CHECKED, OTHERWISE SHOW IT UNCHECKED
	 * --------------------------------------------------------------------
	 */
	public function selectCheckbox($field_name)
	{
		Database::query("SELECT value FROM c_config WHERE field = '{$field_name}';");
		$fetch = Database::fetch();

		if($fetch['value']) {
			$str = "<input type='hidden' name='{$field_name}' value='0'><input type='checkbox' name='{$field_name}' value='1' checked>";
		}
		else {
			$str = "<input type='hidden' name='{$field_name}' value='0'><input type='checkbox' name='{$field_name}' value='1'>";
		}

		return $str;
	}

	/**
	 * --------------------------------------------------------------------
	 * IF 1, THEN CHECKBOX IS CHECKED, OTHERWISE SHOW IT UNCHECKED
	 * --------------------------------------------------------------------
	 */
	public function booleanCheckbox($field_name, $field_value)
	{
		if($field_value) {
			$str = "<input type='hidden' name='{$field_name}' value='0'><input type='checkbox' name='{$field_name}' value='1' checked>";
		}
		else {
			$str = "<input type='hidden' name='{$field_name}' value='0'><input type='checkbox' name='{$field_name}' value='1'>";
		}

		return $str;
	}

	/**
	 * --------------------------------------------------------------------
	 * UPDATE CONFIGURATION TABLE
	 * FORMAT $config['field'] = "value" MUST BE USED!
	 * --------------------------------------------------------------------
	 */
	public function saveConfig($post)
	{
		if(is_array($post)) {
			foreach($post as $k => $v) {
				Database::query("UPDATE c_config SET value = '{$v}' WHERE field = '{$k}';");
			}
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * --------------------------------------------------------------------
	 * ADD REGISTER TO ADMIN LOG
	 * --------------------------------------------------------------------
	 */
	public function registerLog($message)
	{
		$log = array(
			"member_id" => $_SESSION['admin_m_id'],
			"time"      => time(),
			"message"   => $message,
			"ip_addr"   => $_SERVER['REMOTE_ADDR']
		);

		Database::query("INSERT INTO c_logs (member_id, time, act, ip_address) VALUES
			('{$log['member_id']}', '{$log['time']}', '{$log['message']}', '{$log['ip_addr']}');");
	}

	/**
	 * --------------------------------------------------------------------
	 * REPLACE TRUE/FALSE AND 1/0 INTO GREEN "YES" AND RED "NO"
	 * --------------------------------------------------------------------
	 */
	public function showBoolean($value) {
		if($value) {
			return "<span style='color:#090'>Yes</span>";
		}
		elseif(!$value) {
			return "<span style='color:#C00'>No</span>";
		}
		else {
			return false;
		}
	}
}
