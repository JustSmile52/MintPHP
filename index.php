<?php
$JSON_list = file_get_contents('list.json');
$JSON_tree = file_get_contents('tree.json');
$JSON_tree_array = json_decode($JSON_tree);
$JSON_list_array = json_decode($JSON_list);
$nazwy = [];
$start = 0;
foreach($JSON_list_array as $item){
 $tablica = [];
 $id = $item->category_id;
 $name = $item->translations->pl_PL->name;
 array_push($tablica,$id,$name);
 array_push($nazwy,$tablica);
}
function main($tree, $nazwy, $spacje){
    $tabulacja = $spacje +1;
    
    foreach($tree as $item){
        echo '<div style="margin-left:'.$tabulacja.'vw"><p >{';
        if(if_exists($item->id,$nazwy)){ 
        echo '"id":'.$item->id.', "name":'.id_into_name($item->id,$nazwy).',"children":[';
        main($item->children,$nazwy,$tabulacja);  
        }
        else{
        echo '"id":'.$item->id.', "name":" - ","children":[';
        main($item->children,$nazwy,$tabulacja);
        }
        echo ' ]}</p></div>';
       
    }
    
}
function if_exists($cos, $nazwy){
    $istnieje = false;
    foreach($nazwy as $item){
     if($item[0] == $cos){
        $istnieje = true;
     }
     
    }
    return $istnieje;
}
function id_into_name($cos,$nazwy){
    $name = "";
    foreach($nazwy as $item){
     if($item[0] == $cos){
        $name = $item[1];
     }
     
    }
    return $name;
}
echo '<p>[</p>';
echo '<div  style="margin-left:3vw">';
main($JSON_tree_array, $nazwy, $start);
echo'</div>';
echo '<p>]</p>';
