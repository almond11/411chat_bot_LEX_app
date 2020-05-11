<?php

/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');



$keyword = param('keyword');
$ingredients = param('ingredients');
$notingredients = param('notingredients');

if(!empty($keyword)){
	$keyword = trim($keyword);
	if(strlen($keyword)> 3){
	   $recipelist = db_sql_find("SELECT * from bbs_recipe where  title like '%".$keyword."%' limit 30;"); 
	   //print("<pre>".print_r($recipelist,true)."</pre>");
	   
	   if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   
	 }
}
if(!empty($ingredients)){
	$ingredients = trim($ingredients);
	
	if(strlen($ingredients)> 3){
	   $recipelist = db_sql_find("SELECT * from bbs_recipe where  title like '%".$keyword."%' limit 30;"); 
	   $ingredient = db_sql_find_one("SELECT b.* from bbs_recipe a JOIN bbs_ingredient b ON  a.id = ".$rid." AND a.ingredient_id=b.ingredient_id  limit 30"); 
	   //print("<pre>".print_r($recipelist,true)."</pre>");
	   
	   if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   
	 }
}


if(empty($keyword) and empty($ingredients) and empty($notingredients) ){
    include _include(APP_PATH.'view/htm2/search_advance.html');
  }

//$recipe = db_sql_find_one("SELECT * from bbs_recipe where  id = ".$rid); 

//$ingredient = db_sql_find_one("SELECT b.* from bbs_recipe a JOIN bbs_ingredient b ON  a.id = ".$rid." AND a.ingredient_id=b.ingredient_id "); 
//$r = implode(',', $receiptlist);
//echo $r;
//$receiptlist = db_sql_find("SELECT * from bbs_receipt  where id IN (".implode(',', $r).") "); 

// SEO
$header['title'] = $conf['sitename']; 				// site title
$header['keywords'] = ''; 					// site keyword
$header['description'] = $conf['sitebrief']; 			// site description
$_SESSION['fid'] = 0;







//include _include(APP_PATH.'view/htm/test.htm');

?>