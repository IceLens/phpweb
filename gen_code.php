
<?php
/*
function str_rand($length=32,$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): false|string
{
    if(!is_int($length)||$length<0){
        return false;
    }
    $characters_length=strlen($characters)-1;
    $string='';
    for($i=$length;$i>0;$i--){
        $string.=$characters[mt_rand(0,$characters_length)];
    }
    return $string;
}

$random =  str_rand();
print 'Random'."\r\n".$random;
$code = password_hash($random,PASSWORD_BCRYPT);
print 'Code'."\r\n".$code;
*/
print password_hash('1234561',PASSWORD_BCRYPT);


