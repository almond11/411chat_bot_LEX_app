<?php

/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');

// hook index_start.php

$page = param(1, 1);
$order = $conf['order_default'];
$order != 'tid' AND $order = 'lastpid';
$pagesize = $conf['pagesize'];
$active = 'default';

// 从默认的地方读取主题列表
$recipelist = db_sql_find("SELECT floor(RAND() * (SELECT MAX(recipeid) FROM bbs_recipe)) as recipeid from bbs_recipe limit 25"); 
$arr="";
foreach($recipelist as $recipe) {
    if(empty($arr))
    		$arr = $recipe['recipeid'];
    else
    		$arr = $arr.",".$recipe['recipeid'];
}

$recipelist = db_sql_find("SELECT * from bbs_recipe where recipeid IN (".$arr.") limit 20"); 
//$r = implode(',', $recipelist);
//echo $r;
//$recipelist = db_sql_find("SELECT * from bbs_recipe  where id IN (".implode(',', $r).") "); 


//print("<pre>".print_r($recipelist,true)."</pre>");

// SEO
$header['title'] = $conf['sitename']; 				// site title
$header['keywords'] = ''; 					// site keyword
$header['description'] = $conf['sitebrief']; 			// site description
$_SESSION['fid'] = 0;

// hook index_end.php

include _include(APP_PATH.'view/htm2/index.html');

?>