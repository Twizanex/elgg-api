<?php
function page_list($username, $offset = 0, $limit = 20,  $sort = 'relevance', $order = 'desc')	{
	//if $username is not provided then try and get the loggedin user
	if(!$username){
		$user = elgg_get_logged_in_user_entity();
	} else {
		$user = get_user_by_username($username);
	}
	
	if (!$user) {
		throw new InvalidParameterException('registration:usernamenotvalid');
	}
	// set up  params
	$params = array(
		'username' => $username,
		'offset' => $offset,
		'limit' => $limit,
		'sort' => $sort,
		'order' => $order
	);
	if($username){
		$result["pages"]=json_decode(elgg_view_resource('pages/owner',$params));
	}else{
		$result["pages"]="Please give username";
	}
	
	return $result;
}

elgg_ws_expose_function('page.list',
	"page_list",
	array(
		'username' => array ('type' => 'string','required' => true),
		'offset' => array ('type' => 'int','required' => false),
		'limit' => array ('type' => 'int','required' => false),
		'sort' => array ('type' => 'string','required' => false),
		'order' => array ('type' => 'string','required' => false),
	),
	"list of all pages",
	'GET',
    true,
    true);