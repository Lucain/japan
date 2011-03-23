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

loadCommonWhiteList();

$VB_API_WHITELIST = array(
	'response' => array(
		'attachmentoption' => $VB_API_WHITELIST_COMMON['attachmentoption'],
		'disablesmiliesoption', 'emailchecked', 'explicitchecked',
		'folderbits',
		'foruminfo' => $VB_API_WHITELIST_COMMON['foruminfo'],
		'forumrules', 'human_verify', 'newpost',
		'podcastauthor', 'podcastkeywords', 'podcastsize', 'podcastsubtitle',
		'podcasturl', 'polloptions', 'posthash', 'posticons', 'postpreview',
		'poststarttime', 'prefix_options', 'selectedicon', 'subject',
		'tags_remain', 'tag_delimiters', 'htmloption'
	),
	'vboptions' => array(
		'postminchars', 'titlemaxchars', 'maxpolloptions'
	),
	'show' => array(
		'tag_option', 'posticons', 'smiliebox', 'attach', 'threadrating',
		'openclose', 'stickunstick', 'closethread', 'unstickthread',
		'subscribefolders', 'reviewmore', 'parseurl', 'misc_options',
		'additional_options', 'poll', 'podcasturl', 'tags_remain'
	)
);

/*======================================================================*\
|| ####################################################################
|| # Downloaded: 17:46, Fri Mar 11th 2011
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/