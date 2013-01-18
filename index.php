<?php

require_once '../topcode_clip.php';
$template->path(dirname(__FILE__));
$ac = $_GET['ac'];
if ($ac == 'add' or $ac == 'edit') {
     if($ac == 'edit') {
        $content = $db->GetRow("select * from section_football where id = ?  ",array($_GET['id']));
        $_GET['section'] = $content['Clip_Section'];
        $template->assign("content",$content);
    }
    $template->render('section/form.tpl');
} else if ($ac == 'save' or $ac == 'update') {
    $content = $db->GetRow("select id from section_football where id = ?  ",array($_POST['id']));
    if($content['id'] > 0) {
        $db->Execute('update section_football set 
            name = ?
 
            where id = ?
        ',
         array(trim($_POST['clip_name']),trim($_POST['id']))
      );
        
    } else {
         $db->Execute('insert into section_football( 
            id , name , total
            ) values(\'\',?,?)
        ',
         array(trim($_POST['clip_name']),0)
      );
        
    }
    
    $message = 'บันทึกข้อมูลเรียบร้อย';
    
    $template->assign("message",$message);
    $template->assign("time",3);
    $template->assign("url",$_POST['rtn']);
    
    $template->render('section/message.tpl');
} else {
    $content = $db->GetAll("select * from section_football");
    $template->assign("content", $content);
    $template->render('section/list.tpl');
}
?>