<?php
/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');

// hook index_start.php

$action = param(1);
$recipeid =  param(2);
//print("<pre>".print_r($_POST,true)."</pre>");


if(empty($action)){
			$recipeTypeList = db_sql_find("SELECT * FROM bbs_recipeingred group by ingredient ORDER BY ingredient; ");
			// SEO
			$header['title'] = $conf['sitename']; 				// site title
			$header['keywords'] = ''; 					// site keyword
			$header['description'] = $conf['sitebrief']; 			// site description
			$_SESSION['fid'] = 0;

			// hook index_end.php

			include _include(APP_PATH.'view/htm2/recipe_submit.html');
}
else if($action =="add"){

 	   if(!empty($_POST['title']) AND !empty($_POST['ingredient_1'])){	  
 	   	 	
		     $recipeId = db_insert('recipe', 
					 array(
						 'title'=>$_POST['title'],
						 'rating'=>$_POST['rating'],
						 'calories'=>$_POST['calories'],
						 'fat'=>$_POST['fat'],
						 'protein'=>$_POST['protein'],
						 'sodium'=>$_POST['sodium'],
					 ));
					 

			   for($i=0;$i<6;$i++){
			   	   $ingredName = "ingredient_".$i;
			   	   $ingredient_id = $_POST[$ingredName];
			   	   
			   	   if(!empty($ingredient_id)){
			   	   	
			   	   	   $recipeType = db_sql_find_one("SELECT * FROM bbs_recipeingred where ingredient_id = ".$ingredient_id);
			   	   	   
					   	   db_insert('recipeingred',
					   	       array( 'recipeid'=>$recipeId,
									 	'ingredient'=> $recipeType['ingredient'],
									 	'ingredient_id'=>$ingredient_id,
									 ));
							}
			     }

           http_location(url('recipe-'.$recipeId));

					 	
				} 
	

	   //header("Location: http://blog.csdn.net/abandonship");


}
else if($action =="edit"){
			$recipe = db_sql_find_one("SELECT * from bbs_recipe  where recipeid = ".$recipeid); 
			$recipeTypeList = db_sql_find("SELECT * FROM bbs_recipeingred group by ingredient ORDER BY ingredient; ");
			
            $ingredList = db_sql_find("SELECT * from bbs_recipeingred  where recipeid = ".$recipeid);

			// hook index_end.php

			include _include(APP_PATH.'view/htm2/recipe_submit.html');
}
else if($action =="update"){

 	   if(!empty($_POST['recipeid'])  AND !empty($_POST['title']) AND !empty($_POST['ingredient_1'])){	  
 	   	 	

			$update =  array(
						 'title'=>$_POST['title'],
						 'rating'=>$_POST['rating'],
						 'calories'=>$_POST['calories'],
						 'fat'=>$_POST['fat'],
						 'protein'=>$_POST['protein'],
						 'sodium'=>$_POST['sodium'],
					 );
			db_update('recipe', array('recipeid'=>$_POST['recipeid']), $update);
			
			db_delete('recipeingred', array('recipeid'=>$_POST['recipeid']));
			
			for($i=0;$i<9;$i++){
			   	   $ingredName = "ingredient_".$i;
			   	   $ingredient_id = $_POST[$ingredName];
			   	   
			   	   if(!empty($ingredient_id)){
			   	   	
			   	   	   $recipeType = db_sql_find_one("SELECT * FROM bbs_recipeingred where ingredient_id = ".$ingredient_id);
			   	   	   
					   	   db_insert('recipeingred',
					   	       array( 'recipeid'=>$_POST['recipeid'],
									  'ingredient'=> $recipeType['ingredient'],
								     'ingredient_id'=>$ingredient_id,
									 ));
					}
			}

           http_location(url('recipe-'.$_POST['recipeid']));

					 	
		} 

}
else if($action =="delete"){

 	   if(!empty($recipeid) ){	  
 	   	  db_delete('recipeingred', array('recipeid'=>$recipeid));	
          db_delete('recipe', array('recipeid'=>$recipeid));
          http_location(url('/'));
		} 

}
?>