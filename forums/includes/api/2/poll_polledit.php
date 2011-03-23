<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.1.2 - Licence Number VBFC7872E8
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000-2011 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
if (!VB_API) die;

$VB_API_WHITELIST = array(
	'response' => array(
		'forumrules', 'pollbits',
		'pollinfo' => array(
			'question', 'timeout', 'posttime', 'public', 'closed'
		),
		'threadinfo'  => $VB_API_WHITELIST_COMMON['threadinfo'],
	)
);

function api_result_prerender_2($t, &$r)
{
	switch ($t)
	{
		case 'editpoll':
			$r['pollinfo']['posttime'] = $r['pollinfo']['dateline'];
			break;
	}
}

vB_APICallback::instance()->add('result_prerender', 'api_result_prerender_2', 2);

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 17:46, Fri Mar 11th 2011
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/