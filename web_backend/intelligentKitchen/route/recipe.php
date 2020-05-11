<?php

/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');

// hook index_start.php

$rid = param(1);

//echo $rid;

//$recipelist = db_sql_find("SELECT * from bbs_recipe a,bbs_recipeingred b where a.recipeid = ".$rid."  AND a.recipeid = b.recipeid "); 

$recipe = db_sql_find_one("SELECT * from bbs_recipe  where recipeid = ".$rid); 
$ingredList = db_sql_find("SELECT * from bbs_recipeingred  where recipeid = ".$rid); 

$arr="";
foreach($ingredList as $ingred) {
    if(empty($arr))
    		$arr = $ingred['ingredient_id'];
    else
    		$arr = $arr.",".$ingred['ingredient_id'];
}

$eleList = db_sql_find("SELECT * from bbs_ingredient where ingredient_id IN (".$arr.")  "); 

$recommendation = db_sql_find_one("SELECT * from bbs_recommendation where recipeid = ".$rid);

$arr = $recommendation['rec1'].",".$recommendation['rec2'].",".$recommendation['rec3'].",".$recommendation['rec4'].",".$recommendation['rec5'].",".$recommendation['rec6'].",".$recommendation['rec7'].",".$recommendation['rec8'].",".$recommendation['rec9'].",".$recommendation['rec10'];

$recommendationList = db_sql_find("SELECT * from bbs_recipe where recipeid IN (".$arr.")  ");

//$r = implode(',', $receiptlist);
//echo $r;
//$receiptlist = db_sql_find("SELECT * from bbs_receipt  where id IN (".implode(',', $r).") "); 


//print("<pre>".print_r($recipe,true)."</pre>");

// SEO
$header['title'] = $conf['sitename']; 				// site title
$header['keywords'] = ''; 					// site keyword
$header['description'] = $conf['sitebrief']; 			// site description
$_SESSION['fid'] = 0;

// hook index_end.php

include _include(APP_PATH.'view/htm2/recipe_single.html');

?>