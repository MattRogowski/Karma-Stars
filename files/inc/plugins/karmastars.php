<?php
/**
 * Karma Stars 1.1.1

 * Copyright 2016 Matthew Rogowski

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 ** http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
**/

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("postbit", "karmastars_postbit");
$plugins->add_hook("member_profile_end", "karmastars_profile");
$plugins->add_hook("misc_start", "karmastars_list");
$plugins->add_hook("global_start", "karmastars_footer");
$plugins->add_hook("fetch_wol_activity_end", "karmastars_friendly_wol");
$plugins->add_hook("build_friendly_wol_location_end", "karmastars_build_wol");
$plugins->add_hook("admin_user_menu", "karmastars_admin_user_menu");
$plugins->add_hook("admin_user_action_handler", "karmastars_admin_user_action_handler");
$plugins->add_hook("admin_user_permissions", "karmastars_admin_user_permissions");

global $templatelist;

if($templatelist)
{
	$templatelist .= ',';
}
$templatelist .= 'karmastars_user_star,karmastars_list,karmastars_list_row,karmastars_list_row_percentage';

function karmastars_info()
{
	return array(
		"name" => "Karma Stars",
		"description" => "Earn 'karma' and collect stars for posting.",
		"website" => "https://github.com/MattRogowski/Karma-Stars",
		"author" => "Matt Rogowski",
		"authorsite" => "https://matt.rogow.ski",
		"version" => "1.1.1",
		"compatibility" => "16*,18*",
		"codename" => "karmastars"
	);
}

function karmastars_install()
{
	global $db;

	karmastars_uninstall();

	if(!$db->table_exists('karmastars'))
	{
		$db->write_query("
			CREATE TABLE IF NOT EXISTS `" . TABLE_PREFIX . "karmastars` (
				`karmastar_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`karmastar_posts` INT( 5 ) NOT NULL ,
				`karmastar_name` VARCHAR( 255 ) NOT NULL ,
				`karmastar_image` VARCHAR( 255 ) NOT NULL
			) ENGINE = MYISAM ;
		");
		$karmastars = array(
			array(
				'image' => 'images/karmastars/1_small_silver.gif',
				'posts' => '20',
				'name' => 'One Small Silver Star'
			),
			array(
				'image' => 'images/karmastars/2_small_silver.gif',
				'posts' => '50',
				'name' => 'Two Small Silver Stars'
			),
			array(
				'image' => 'images/karmastars/3_small_silver.gif',
				'posts' => '125',
				'name' => 'Three Small Silver Stars'
			),
			array(
				'image' => 'images/karmastars/4_small_silver.gif',
				'posts' => '250',
				'name' => 'Four Small Silver Stars'
			),
			array(
				'image' => 'images/karmastars/1_small_gold.gif',
				'posts' => '550',
				'name' => 'One Small Gold Star'
			),
			array(
				'image' => 'images/karmastars/2_small_gold.gif',
				'posts' => '1000',
				'name' => 'Two Small Gold Stars'
			),
			array(
				'image' => 'images/karmastars/3_small_gold.gif',
				'posts' => '1500',
				'name' => 'Three Small Gold Stars'
			),
			array(
				'image' => 'images/karmastars/4_small_gold.gif',
				'posts' => '2200',
				'name' => 'Four Small Gold Stars'
			),
			array(
				'image' => 'images/karmastars/1_med_silver.gif',
				'posts' => '3000',
				'name' => 'One Medium Silver Star'
			),
			array(
				'image' => 'images/karmastars/2_med_silver.gif',
				'posts' => '4000',
				'name' => 'Two Medium Silver Stars'
			),
			array(
				'image' => 'images/karmastars/1_med_gold.gif',
				'posts' => '5500',
				'name' => 'One Medium Gold Star'
			),
			array(
				'image' => 'images/karmastars/2_med_gold.gif',
				'posts' => '7500',
				'name' => 'Two Medium Gold Stars'
			),
			array(
				'image' => 'images/karmastars/1_large_silver.gif',
				'posts' => '10000',
				'name' => 'One Large Silver Star'
			),
			array(
				'image' => 'images/karmastars/1_large_silver_sparkling.gif',
				'posts' => '12500',
				'name' => 'One Large Sparkling Silver Star'
			),
			array(
				'image' => 'images/karmastars/1_large_gold.gif',
				'posts' => '15000',
				'name' => 'One Large Gold Star'
			),
			array(
				'image' => 'images/karmastars/1_large_gold_sparkling.gif',
				'posts' => '17500',
				'name' => 'One Large Sparkling Gold Star'
			),
			array(
				'image' => 'images/karmastars/1_large_spinning.gif',
				'posts' => '20000',
				'name' => 'One Large Spinning Star'
			),
			array(
				'image' => 'images/karmastars/1_large_platinum.gif',
				'posts' => '25000',
				'name' => 'One Large Platinum Star'
			),
			array(
				'image' => 'images/karmastars/1_large_blue.gif',
				'posts' => '30000',
				'name' => 'One Large Blue Star'
			),
			array(
				'image' => 'images/karmastars/1_large_orange.gif',
				'posts' => '35000',
				'name' => 'One Large Orange Star'
			),
			array(
				'image' => 'images/karmastars/1_large_flashing.gif',
				'posts' => '40000',
				'name' => 'One Large Flashing Star'
			)
		);
		foreach($karmastars as $karmastar)
		{
			$insert = array(
				'karmastar_image' => $db->escape_string($karmastar['image']),
				'karmastar_posts' => $db->escape_string($karmastar['posts']),
				'karmastar_name' => $db->escape_string($karmastar['name'])
			);
			$db->insert_query('karmastars', $insert);
		}
		update_karmastars();
	}
}

function karmastars_is_installed()
{
	global $db;

	return $db->table_exists('karmastars');
}

function karmastars_uninstall()
{
	global $db;

	if($db->table_exists('karmastars'))
	{
		$db->drop_table('karmastars');
	}

	$db->delete_query('datacache', 'title = \'karmastars\'');
}

function karmastars_activate()
{
	global $mybb, $db;

	karmastars_deactivate();

	require_once MYBB_ROOT . 'inc/adminfunctions_templates.php';

	find_replace_templatesets("postbit", "#".preg_quote('{$post[\'onlinestatus\']}')."#i", '{$post[\'karmastar\']}{$post[\'onlinestatus\']}');
	find_replace_templatesets("postbit_classic", "#".preg_quote('{$post[\'onlinestatus\']}')."#i", '{$post[\'karmastar\']}{$post[\'onlinestatus\']}');
	find_replace_templatesets("member_profile", "#".preg_quote('<span class="largetext"><strong>{$formattedname}</strong></span><br />')."#i", '<span class="largetext"><strong>{$formattedname}</strong></span>{$memprofile[\'karmastar\']}<br />');
	if(substr($mybb->version, 0, 3) == '1.6')
	{
		find_replace_templatesets("footer", "#".preg_quote('{$lang->bottomlinks_syndication}</a>')."#i", '{$lang->bottomlinks_syndication}</a> | <a href="{$mybb->settings[\'bburl\']}/misc.php?action=karmastars">{$lang->karmastars}</a>');
	}
	elseif(substr($mybb->version, 0, 3) == '1.8')
	{
		find_replace_templatesets("footer", "#".preg_quote('{$lang->bottomlinks_syndication}</a></li>')."#i", '{$lang->bottomlinks_syndication}</a></li>'."\n\t\t\t\t".'<li><a href="{$mybb->settings[\'bburl\']}/misc.php?action=karmastars">{$lang->karmastars}</a></li>');
	}

	$templates = array();
	$templates[] = array(
		"title" => "karmastars_user_star",
		"template" => "<a href=\"{\$mybb->settings['bburl']}/misc.php?action=karmastars&amp;uid={\$karmastar_uid}\" target=\"_blank\"><img src=\"{\$mybb->settings['bburl']}/{\$karmastar['karmastar_image']}\" alt=\"{\$karmastar['karmastar_name']}\" title=\"{\$karmastar['karmastar_name']}\" /></a>"
	);
	$templates[] = array(
		"title" => "karmastars_list",
		"template" => "<html>
<head>
<title>{\$lang->karmastars}</title>
{\$headerinclude}
</head>
<body>
{\$header}
<table border=\"0\" cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder\">
	<tr>
		<td class=\"thead\" colspan=\"3\">
			<strong>{\$table_title}</strong>
			<div class=\"float_right\">{\$view_own}</div>
		</td>
	</tr>
	<tr>
		<td class=\"tcat\" align=\"center\">
			<strong>{\$lang->karmastars_image}</strong>
		</td>
		<td class=\"tcat\" align=\"center\">
			<strong>{\$lang->karmastars_posts}</strong>
		</td>
		<td class=\"tcat\">
			<strong>{\$lang->karmastars_name}</strong>
		</td>
	</tr>
	{\$karmastars_list}
	<tr>
		<td class=\"tfoot\" colspan=\"3\">
			<div class=\"float_right\"><a href=\"{\$view_top_link}\">{\$view_top_text}</a></div>
		</td>
	</tr>
</table>
{\$footer}
</body>
</html>"
	);
	$templates[] = array(
		"title" => "karmastars_list_row",
		"template" => "<tr{\$selected}>
	<td class=\"{\$trow}\" align=\"center\">
		<img src=\"{\$mybb->settings['bburl']}/{\$karmastar['karmastar_image']}\" alt=\"{\$karmastar['karmastar_name']}\" title=\"{\$karmastar['karmastar_name']}\" />
	</td>
	<td class=\"{\$trow}\" align=\"center\">
		{\$karmastar_posts}{\$karmastar_diff}
	</td>
	<td class=\"{\$trow}\">
		{\$karmastar['karmastar_name']}{\$karma_top_users}
	</td>
</tr>"
	);
	$templates[] = array(
		"title" => "karmastars_list_row_percentage",
		"template" => "<tr>
	<td class=\"{\$trow}\" style=\"padding: 0;\" colspan=\"3\" align=\"center\">
		<div style=\"width: 100%; position: relative; text-align: center; padding: 5px 0px;\">
			<div style=\"width: {\$percentage_done}%; height: 100%; position: absolute; left: 0; top: 0; background: #D6ECA6;\"></div>
			<div style=\"position: relative;\">{\$percentage_left}</div>
		</div>
	</td>
</tr>"
	);

	foreach($templates as $template)
	{
		$insert = array(
			"title" => $db->escape_string($template['title']),
			"template" => $db->escape_string($template['template']),
			"sid" => "-1",
			"version" => "1800",
			"status" => "",
			"dateline" => TIME_NOW
		);

		$db->insert_query("templates", $insert);
	}
}

function karmastars_deactivate()
{
	global $mybb, $db;

	require_once MYBB_ROOT . 'inc/adminfunctions_templates.php';

	find_replace_templatesets("postbit", "#".preg_quote('{$post[\'karmastar\']}')."#i", '', 0);
	find_replace_templatesets("postbit_classic", "#".preg_quote('{$post[\'karmastar\']}')."#i", '', 0);
	find_replace_templatesets("member_profile", "#".preg_quote('{$memprofile[\'karmastar\']}')."#i", '', 0);
	if(substr($mybb->version, 0, 3) == '1.6')
	{
		find_replace_templatesets("footer", "#".preg_quote(' | <a href="{$mybb->settings[\'bburl\']}/misc.php?action=karmastars">{$lang->karmastars}</a>')."#i", '', 0);
	}
	elseif(substr($mybb->version, 0, 3) == '1.8')
	{
		find_replace_templatesets("footer", "#".preg_quote("\n\t\t\t\t".'<li><a href="{$mybb->settings[\'bburl\']}/misc.php?action=karmastars">{$lang->karmastars}</a></li>')."#i", '', 0);
	}

	$db->delete_query("templates", "title IN ('karmastars_user_star','karmastars_list','karmastars_list_row','karmastars_list_row_percentage')");
}

function update_karmastars()
{
	global $db, $cache;

	$query = $db->simple_select('karmastars', '*', '', array('order_by' => 'karmastar_posts', 'order_dir' => 'ASC'));
	$karmastars = array();
	while($karmastar = $db->fetch_array($query))
	{
		$karmastars[] = $karmastar;
	}
	$cache->update('karmastars', $karmastars);
}

function karmastars_get_karma($posts)
{
	global $mybb, $cache;

	$posts = intval(str_replace($mybb->settings['thousandssep'], '', $posts));

	$karmastars = $cache->read('karmastars');
	$karmastars = array_reverse($karmastars);

	foreach($karmastars as $karmastar)
	{
		if($posts >= $karmastar['karmastar_posts'])
		{
			return $karmastar;
		}
	}

	return false;
}

function karmastars_postbit(&$post)
{
	global $mybb, $templates;

	$post['karmastar'] = '';
	$karmastar = karmastars_get_karma($post['postnum']);
	if($karmastar)
	{
		$karmastar_uid = $post['uid'];
		eval("\$post['karmastar'] = \"".$templates->get('karmastars_user_star')."\";");
	}
}

function karmastars_profile()
{
	global $mybb, $templates, $memprofile;

	$memprofile['karmastar'] = '';
	$karmastar = karmastars_get_karma($memprofile['postnum']);
	if($karmastar)
	{
		$karmastar_uid = $memprofile['uid'];
		eval("\$memprofile['karmastar'] = \"".$templates->get('karmastars_user_star')."\";");
	}
}

function karmastars_list()
{
	global $mybb, $db, $cache, $lang, $templates, $theme, $header, $headerinclude, $footer, $karmastars_list;

	if($mybb->input['action'] == 'karmastars')
	{
		$lang->load('karmastars');

		$view_top = false;
		if($mybb->input['viewtop'] == 1)
		{
			$view_top = true;
		}

		$uid = 0;
		$view_own = '';
		if($mybb->input['uid'] && !$view_top)
		{
			$user = get_user($mybb->input['uid']);
			if($user && $user['uid'] != $mybb->user['uid'])
			{
				$uid = $user['uid'];
				$postnum = $user['postnum'];
				$table_title = $lang->sprintf($lang->karmastars_user, $user['username']);
				$view_own = '<a href="misc.php?action=karmastars">'.$lang->karmastars_view_own.'</a>';
			}
		}
		if(!$uid)
		{
			$uid = $mybb->user['uid'];
			$postnum = $mybb->user['postnum'];
			$table_title = $lang->karmastars;
		}

		if($view_top)
		{
			$query = $db->simple_select('users', 'uid, username, usergroup, displaygroup, postnum', 'postnum > 0', array('order_by' => 'postnum', 'order_dir' => 'desc', 'limit' => 20));
			$users = array();
			while($user = $db->fetch_array($query))
			{
				$users[] = $user;
			}
		}

		$karmastars = $cache->read('karmastars');
		$prev_karma = null;
		foreach($karmastars as $i => $karmastar)
		{
			$trow = alt_trow();
			$selected = '';
			$next_user_karma = $next_karma = null;
			$earned_karma = $last_karma = false;
			$karma_top_users = $karmastar_diff = '';
			if($uid)
			{
				$user_karmastar = karmastars_get_karma($postnum);
				if($user_karmastar)
				{
					if($user_karmastar['karmastar_id'] == $karmastar['karmastar_id'])
					{
						$selected = ' class="trow_selected"';
						$earned_karma = true;
						if(array_key_exists(($i + 1), $karmastars))
						{
							$next_user_karma = $karmastars[($i + 1)];
						}
					}
				}
				elseif($i == 0)
				{
					$next_user_karma = $karmastar;
				}
			}
			if($view_top && (array_key_exists(($i + 1), $karmastars) || ($i + 1 == count($karmastars))))
			{
				if($i + 1 == count($karmastars))
				{
					$last_karma = true;
				}
				else
				{
					$next_karma = $karmastars[($i + 1)];
				}
				$karma_top_users = array();
				foreach($users as $u => $user)
				{
					if($last_karma || $next_karma['karmastar_posts'] > $user['postnum'])
					{
						$formatted_name = format_name($user['username'], $user['usergroup'], $user['displaygroup']).' ('.number_format($user['postnum']).')';
						$profile_link = build_profile_link($formatted_name, $user['uid'], '_blank');
						$karma_top_users[] = $profile_link;
						unset($users[$u]);
					}
				}
				$karma_top_users = '<br />'.implode(', ', $karma_top_users);
			}
			if($prev_karma)
			{
				$karmastar_diff = ' <small><em>(+'.number_format($karmastar['karmastar_posts']-$prev_karma['karmastar_posts']).')</em></small>';
			}
			$karmastar_posts = number_format($karmastar['karmastar_posts']);
			if($earned_karma)
			{
				eval("\$karmastars_list .= \"".$templates->get('karmastars_list_row')."\";");
			}
			if($next_user_karma)
			{
				$posts_left = $next_user_karma['karmastar_posts'] - $postnum;
				if(!$earned_karma)
				{
					$posts_difference = $next_user_karma['karmastar_posts'];
					$posts_done = $postnum;
				}
				else
				{
					$posts_difference = $next_user_karma['karmastar_posts'] - $karmastar['karmastar_posts'];
					$posts_done = $postnum - $karmastar['karmastar_posts'];
				}
				$percentage_done = round(($posts_done / $posts_difference) * 100);
				$percentage_left = $lang->sprintf($lang->karmastars_next_level, number_format($postnum), number_format($posts_left));
				eval("\$karmastars_list .= \"".$templates->get('karmastars_list_row_percentage')."\";");
			}
			if(!$earned_karma)
			{
				eval("\$karmastars_list .= \"".$templates->get('karmastars_list_row')."\";");
			}
			$prev_karma = $karmastar;
		}

		if($view_top)
		{
			$view_top_link = 'misc.php?action=karmastars';
			$view_top_text = $lang->karmastars_hide_top;
		}
		else
		{
			$view_top_link = 'misc.php?action=karmastars&amp;viewtop=1';
			$view_top_text = $lang->karmastars_view_top;
		}

		add_breadcrumb($lang->karmastars);
		eval("\$karmastars_page = \"".$templates->get('karmastars_list')."\";");
		output_page($karmastars_page);
	}
}

function karmastars_footer()
{
	global $lang;

	$lang->load('karmastars');
}

function karmastars_friendly_wol(&$user_activity)
{
	global $user;

	if(my_strpos($user['location'], "misc.php?action=karmastars") !== false)
	{
		$user_activity['activity'] = "misc_karmastars";
	}
}

function karmastars_build_wol(&$plugin_array)
{
	global $lang;

	$lang->load("karmastars");

	if($plugin_array['user_activity']['activity'] == "misc_karmastars")
	{
		$plugin_array['location_name'] = $lang->karmastars_wol;
	}
}

function karmastars_admin_user_menu($sub_menu)
{
	global $lang;

	$lang->load("user_karmastars");

	$sub_menu[] = array("id" => "karmastars", "title" => $lang->karmastars, "link" => "index.php?module=user-karmastars");

	return $sub_menu;
}

function karmastars_admin_user_action_handler($actions)
{
	$actions['karmastars'] = array(
		"active" => "karmastars",
		"file" => "karmastars.php"
	);

	return $actions;
}

function karmastars_admin_user_permissions($admin_permissions)
{
	global $lang;

	$lang->load("user_karmastars");

	$admin_permissions['karmastars'] = $lang->can_manage_karmastars;

	return $admin_permissions;
}

function karmastars_list_images()
{
	$karmastars = opendir(MYBB_ROOT.'images/karmastars/');
	while(($image = readdir($karmastars)) !== false)
	{
		echo 'images/karmastars/'.$image.'<br />';
	}
}
?>
