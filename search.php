<?php
require_once("functions/DatabaseClass.php");

$database = new DatabaseClass();
$output = '';
if(isset($_POST["query"]))
{
	$search = trim($_POST["query"]);
	$query = "SELECT * FROM posts WHERE title LIKE '%" . $search . "%'";
}
else
{
	$query = "SELECT * FROM posts ";
}
$posts = $database->Read($query);
	$output .= '';
	foreach ($posts as $post)
	{
		$post_slug= $post['slug'];
		$output .= '
			<tr style="width:100%;background: white; border:1px solid #7386D5;">
				<td style="border-bottom:solid 1px #7386D5;"><a href="single.php?id=' . $post_slug . '" style="text-decoration:none;">'.$post["title"].'</a></td>
			</tr>
		';
	}
	echo $output;
?>