<?php

/*
* Copyright (C) 2015 xiuno.com
*/

!defined('DEBUG') AND exit('Access Denied.');

// hook index_start.php

$rid = param(1, 1);
//echo $rid;



$list = db_sql_find("SELECT * from bbs_recipeingred  GROUP BY recipeid,title,rating,calories,fat,protein,sodium ; ");
$i = 0; 
foreach($list as $item){
	$i = $i + 1;
	echo $i." ".$item['recipeid']." ".$item['title']."<br>";
	
	 db_insert('recipe', 
					 array(
					 'recipeid'=>$item['recipeid'],
					 'title'=>$item['title'],
					 'rating'=>$item['rating'],
					 'calories'=>$item['calories'],
					 'fat'=>$item['fat'],
					 'protein'=>$item['protein'],
					 'sodium'=>$item['sodium'],
					 ));					 

}
//$r = implode(',', $receiptlist);
//echo $r;
//$receiptlist = db_sql_find("SELECT * from bbs_receipt  where id IN (".implode(',', $r).") "); 


//print("<pre>".print_r($recipeInfo,true)."</pre>");



?>