<?php
/*
 *	http://www.php.net/manual/en/function.mt-rand.php
 *	Random string generator found in
 *	function comentaries.
 *
 */
function mt_rand_str ($l, $c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
    for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
    return $s;
}

function mt_rand_hex_str() {
    $num = mt_rand ( 0, 0xffffff ); // trust the library, love the library...
    $output = sprintf ( "%06x" , $num ); // muchas smoochas to you, PHP!
    return $output;
}
/**
* Check $_FILES[][name]
*
* @param (string) $filename - Uploaded file name.
* @author Yousef Ismaeil Cliprz
*/
function check_file_uploaded_name ($filename)
{
    (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? true : false);
}

/**
* Check $_FILES[][name] length.
*
* @param (string) $filename - Uploaded file name.
* @author Yousef Ismaeil Cliprz.
*/
function check_file_uploaded_length ($filename)
{
    return (bool) ((mb_strlen($filename,"UTF-8") > 150) ? true : false);
}