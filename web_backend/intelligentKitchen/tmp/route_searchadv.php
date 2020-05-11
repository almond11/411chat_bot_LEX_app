<?php

/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');



$keyword = param('keyword');
empty($keyword) AND $keyword = param(1);

$ingredients = param('ingredients');
$notingredients = param('notingredients');

$category = param('category');
empty($category) AND $category = param(2);

$calories = param('calories');
empty($calories) AND $calories = param(3);

$keyword = trim($keyword);
$keyword_decode = strtolower(urldecode($keyword));
$keyword_list = explode(",", $keyword_decode);

$category = trim($category);
$category_decode = urldecode($category);

$calories = trim($calories);
$calories_decode = urldecode($calories);
$calories_boundary = explode(",", $calories_decode);

$ingredientList = db_sql_find("SELECT * FROM bbs_ingredient group by food_group ORDER BY food_group; ");

if(!empty($keyword) and empty($category)){
       if(!empty($calories)) {
           if(sizeof($keyword_list) == 1) {
	         $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' and calories >= ".$calories_boundary[0]." and calories < ".$calories_boundary[1]." limit 30;");
           } else if(sizeof($keyword_list) == 2) { 
             $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' and LOWER(title) like '%".$keyword_list[1]."%' and calories >= ".$calories_boundary[0]." and calories < ".$calories_boundary[1]." limit 30;");
           } else if(sizeof($keyword_list) == 3) {
             $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' and LOWER(title) like '%".$keyword_list[1]."%' and LOWER(title) like '%".$keyword_list[2]."%' and calories >= ".$calories_boundary[0]." and calories < ".$calories_boundary[1]." limit 30;");
           }
	   } else {
	       if(sizeof($keyword_list) == 1) {
	       $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' limit 30;");
           } else if(sizeof($keyword_list) == 2) { 
             $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' and LOWER(title) like '%".$keyword_list[1]."%' limit 30;");
           } else if(sizeof($keyword_list) == 3) {
             $recipelist = db_sql_find("SELECT * from bbs_recipe where LOWER(title) like '%".$keyword_list[0]."%' and LOWER(title) like '%".$keyword_list[1]."%' and LOWER(title) like '%".$keyword_list[2]."%' limit 30;");
           }
	       
	   }
	       
	   if(empty($recipelist)){
	        $recipejoinlist = db_sql_find("SELECT distinct(recipeid) from bbs_recipeingred WHERE LOWER(ingredient) LIKE '%".$keyword_decode."%' limit 30;");
    	    $arr="";
            foreach($recipejoinlist as $recipejoin) {
                if(empty($arr))
                		$arr = $recipejoin['recipeid'];
                else
                		$arr = $arr.",".$recipejoin['recipeid'];
            }
            
            $recipelist = db_sql_find("SELECT * from bbs_recipe where recipeid IN (".$arr.");");
        }
    	    
	   //print("<pre>".print_r($recipelist,true)."</pre>");
	   
	   if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   else 
	       include _include(APP_PATH.'view/htm2/search_advance.html');
}

else if(!empty($category) and empty($keyword)){
       if(!empty($calories))
	       $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group LIKE '%".$category_decode."%' and a.calories >= ".$calories_boundary[0]." and a.calories < ".$calories_boundary[1]." GROUP BY a.recipeid HAVING ingred_count >= 2 ORDER BY ingred_count DESC LIMIT 30"); 
	   else
	       $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group LIKE '%".$category_decode."%' GROUP BY a.recipeid HAVING ingred_count >= 2 ORDER BY ingred_count DESC LIMIT 30"); 
	   // print("<pre>".print_r($recipelist,true)."</pre>");
	   
	   if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   else 
	       include _include(APP_PATH.'view/htm2/search_advance.html');
}

else if(!empty($category) and !empty($keyword)){
       if(!empty($calories)) {
           if(sizeof($keyword_list) == 1) {
    	   $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%' and LOWER(a.title) like '%".$keyword_list[0]."%' and a.calories >= ".$calories_boundary[0]." and a.calories < ".$calories_boundary[1]." GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           } else if(sizeof($keyword_list) == 2) { 
               $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%' and LOWER(a.title) like '%".$keyword_list[0]."%' and LOWER(a.title) like '%".$keyword_list[1]."%' and a.calories >= ".$calories_boundary[0]." and a.calories < ".$calories_boundary[1]." GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           } else if(sizeof($keyword_list) == 3) {
               $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%'  and LOWER(a.title) like '%".$keyword_list[0]."%' and LOWER(a.title) like '%".$keyword_list[1]."%' and LOWER(a.title) like '%".$keyword_list[2]."%' and a.calories >= ".$calories_boundary[0]." and a.calories < ".$calories_boundary[1]." GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           }
       } else {
           if(sizeof($keyword_list) == 1) {
               $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%' AND LOWER(a.title) like '%".$keyword_list[0]."%' GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           } else if(sizeof($keyword_list) == 2) { 
              $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%' AND LOWER(a.title) like '%".$keyword_list[0]."%' AND LOWER(a.title) like '%".$keyword_list[1]."%' GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           } else if(sizeof($keyword_list) == 3) {
              $recipelist = db_sql_find("SELECT a.*, count(*) as ingred_count from bbs_recipe a LEFT JOIN bbs_recipeingred b ON a.recipeid = b.recipeid LEFT JOIN bbs_ingredient c ON  b.ingredient_id=c.ingredient_id WHERE c.food_group like '%".$category_decode."%' AND LOWER(a.title) like '%".$keyword_list[0]."%' AND LOWER(a.title) like '%".$keyword_list[1]."%' AND LOWER(a.title) like '%".$keyword_list[2]."%' GROUP BY a.recipeid ORDER BY ingred_count DESC LIMIT 30;");
           }
       }
	   // print("<pre>".print_r($recipelist,true)."</pre>");
	   
	   if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   else 
	       include _include(APP_PATH.'view/htm2/search_advance.html');
}

else if(empty($category) and empty($keyword) and !empty($calories)) {
    $recipelist = db_sql_find("SELECT * from bbs_recipe where calories >= ".$calories_boundary[0]." and calories < ".$calories_boundary[1]." limit 30;");
    
     if($recipelist)
	       include _include(APP_PATH.'view/htm2/recipe_index.html');
	   else 
	       include _include(APP_PATH.'view/htm2/search_advance.html');
}


if(empty($keyword) and empty($category) and empty($calories)){
    include _include(APP_PATH.'view/htm2/search_advance.html');
  }


// SEO
$header['title'] = $conf['sitename']; 				// site title
$header['keywords'] = ''; 					// site keyword
$header['description'] = $conf['sitebrief']; 			// site description
$_SESSION['fid'] = 0;







//include _include(APP_PATH.'view/htm/test.htm');

?>