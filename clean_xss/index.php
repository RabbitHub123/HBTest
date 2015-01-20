<?php
header("Content-type: text/html; charset=gb2312");   
/**
 * @blog http://www.phpddt.com
 * @param $string
 * @param $low 安全别级低
 */
function clean_xss(&$string, $low = false)
{
	if (! is_array ( $string ))
	{
		$string = trim ( $string );
		$string = strip_tags ( $string );
		$string = htmlspecialchars ( $string );
		if ($low)
		{
			return true;
		}
		$string = str_replace ( array ('"', "\\", "'", "/", "..", "../", "./", "//" ), '', $string );
		$no = '/%0[0-8bcef]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/%1[0-9a-f]/';
		$string = preg_replace ( $no, '', $string );
		$no = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
		$string = preg_replace ( $no, '', $string );
		return true;
	}
	$keys = array_keys ( $string );//返回数组中所有的键名
	foreach ( $keys as $key )
	{
		clean_xss ( $string [$key] );
	}
}
//just a test
$str = 'phpddt.com<meta http-equiv="refresh" content="0;">';
clean_xss($str); //如果你把这个注释掉，你就知道xss攻击的厉害了
//echo $str;
?>

<?php
if (isset($_POST['name'])){
    $str = trim($_POST['name']);  //清理空格
    $str = strip_tags($str);   //过滤html标签
    $str = htmlspecialchars($str); //将字符内容转化为html实体
    $str = addslashes($str);
    echo $str;
}
?>
<form method="post" action="">
<input name="name" type="text">
<input type="submit" value="提交" >
</form>