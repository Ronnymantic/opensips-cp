<?php
/*
 * $Id$
 * Copyright (C) 2008 Voice Sistem SRL
 *
 * This file is part of opensips-cp, a free Web Control Panel Application for 
 * OpenSIPS SIP server.
 *
 * opensips-cp is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * opensips-cp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

 require("template/header.php");
 require("lib/".$page_id.".main.js");
 
 require("../../../config/tools/nathelper/local.inc.php");
 require("../../common/mi_comm.php");
 if (isset($_POST['action'])) $action=$_POST['action'];
 else if (isset($_GET['action'])) $action=$_GET['action'];
      else $action="";
 if (isset($_GET['page'])) $_SESSION[$current_page]=$_GET['page'];
 else if (!isset($_SESSION[$current_page])) $_SESSION[$current_page]=1;
if ($action=="toggle"){

	$toggle_button= $_GET['toggle_button'];
	$sock = $_GET['sock'];
	if ($toggle_button=="enabled") {

        $mi_connectors=get_proxys_by_assoc_id($talk_to_this_assoc_id);
        	// get status from the first one only
	        $comm_type=params($mi_connectors[0]);

        	 mi_command("nh_enable_rtpp $sock 0" , $errors , $status);
	         print_r($errors);
	         $status = trim($status);
	
        	$toggle_button = "disabled";

	} else if ($toggle_button=="disabled") {

        	//      get all rtpproxies
	        $mi_connectors=get_proxys_by_assoc_id($talk_to_this_assoc_id);

        	// get status from the first one only
	        $comm_type=params($mi_connectors[0]);

        	 mi_command("nh_enable_rtpp $sock 1" , $errors , $status);
	         print_r($errors);
	         $status = trim($status);
	        $toggle_button = "enabled";
	}
} 
 
################
# start show #
################
if ($action=="refresh") {
$mi_connectors=get_proxys_by_assoc_id($talk_to_this_assoc_id);
for ($i=0;$i<count($mi_connectors);$i++){	

		$comm_type=params($mi_connectors[$i]);	
		mi_command('nh_show_rtpp',$errors,$status);
                print_r($errors);
                $status = trim($status);
                preg_match_all('/.[\:][\:]\s+[a-z\=0-9]+/',$status,$matches);

//print $result;

	}


}
print_r($result);

##############
# end show#
##############
 
   
 require("template/".$page_id.".main.php");
 require("template/footer.php");
 exit();
 
?>