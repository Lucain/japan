<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin Blog 4.1.2 - Licence Number VBFC7872E8
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2011 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
if (!VB_API) die;

class vB_APIMethod extends vBI_APIMethod
{
	public function output()
	{
		global $vbulletin;

		return $vbulletin->session->vars['dbsessionhash'];
	}
}

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 17:46, Fri Mar 11th 2011
|| # CVS: $RCSfile$ - $Revision: 26995 $
|| ####################################################################
\*======================================================================*/