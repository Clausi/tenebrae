<?php

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

include($phpbb_root_path . 'guild/includes/constants.' . $phpEx);
include($phpbb_root_path . 'guild/includes/functions.' . $phpEx);
include($phpbb_root_path . 'guild/includes/wowarmoryapi.' . $phpEx);


$query = "SELECT uniquekey, name, realm FROM " . $TableNames['roster'] . " WHERE active = '1' AND level >= ".$maxLevel." ORDER BY lastupdate ASC LIMIT 1";
$result = $db->sql_query($query);
$row = $db->sql_fetchrow($result);
$Character = $row['name'];
echo $uniquekey = $row['uniquekey'];
echo "<br />";
echo $Character;
echo "<br />";

$realm = $row['realm'];
if($realm == NULL || $realm == '') $realm = $GuildRealm;

echo $realm;
echo "<br />";
echo $GuildRegion;

$armory = new BattlenetArmory($GuildRegion, $realm);
$armory->setLocale($armoryLocale);
//$armory->UTF8(TRUE);
$armory->setCharactersCacheTTL($WGPConfig['Cache']);

$CharacterData = $armory->getCharacter($Character);

include('character_progress.php');
include('character_ilvl.php');

$query = "UPDATE " . $TableNames['roster'] . " SET lastupdate = NOW() WHERE uniquekey = '".$uniquekey."'";
$result = $db->sql_query($query);
