<?php

elgg_register_event_handler('init', 'system', 'hello_world_page_handler');

// function hello_world_init() {
//     elgg_register_page_handler('hello', 'hello_world_page_handler');
// }

function hello_world_page_handler() {
    //echo elgg_view_resource('hello');
    elgg_unregister_plugin_hook_handler('search:results', 'object', 'search_objects_hook');
    elgg_register_plugin_hook_handler('search:results', 'object', 'my_search_objects_hook');
    //
    if (function_exists("elgg_ws_expose_function")) {
        elgg_ws_expose_function(
            "test.echo",
            "my_echo",
            [
                    "string" => [
                            'type' => 'string',
                    ]
            ],
            'A testing method which echos back a string',
            'POST',
            true,
            false
        );
        elgg_ws_expose_function(
            'wire.post',
            'rest_wire_post',
            array( 'username' => array ('type' => 'string'),
                    'text' => array ('type' => 'string'),
                    ),
            'Post a status update to the wire',
            'POST',
            true,
            false
        );
        elgg_ws_expose_function(
            'all.posts',
            'get_all_posts',
            [],
            'Get All posts',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'my.posts',
            'get_my_posts',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get my posts',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'friend.posts',
            'get_friends_posts',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get my posts',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'total.users',
            'get_total_users',
            [],
            'Get All users',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'active.users',
            'get_active_users',
            [],
            'Get All users',
            'GET',
            true,
            false
        );
        //user api
        elgg_ws_expose_function(
            'user.profile',
            'get_user_profile',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user profile',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.friends',
            'get_user_friendList',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user friends',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.pages',
            'get_user_pages',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user pages',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.groups',
            'get_user_groups',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user group',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.membergroups',
            'get_user_memberGroups',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user member group',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.bookmarks',
            'get_user_bookmarks',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user bookmarks',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'user.files',
            'get_user_files',
            array( 'username' => array ('type' => 'string')
                    ),
            'Get user all files',
            'GET',
            true,
            false
        );
        elgg_ws_expose_function(
            'add.publicPost',
            'set_public_post',
            array( 'username' => array ('type' => 'string')
                    ),
            'set a public post',
            'POST',
            true,
            false
        );
        elgg_ws_expose_function(
            'search.result',
            'get_search_result',
            array( 'q' => array ('type' => 'string')
                    ),
            'Get All users',
            'GET',
            false,
            false
        );
        elgg_ws_expose_function(
            'search.site',
            "site_search",
            array(
                'q' => array ('type' => 'string','required' => true),
                'offset' => array ('type' => 'int','required' => false),
                'search_type' => array ('type' => 'string','required' => false),
                'limit' => array ('type' => 'int','required' => false),
                'entity_type' => array ('type' => 'string','required' => false),
                'entity_subtype' => array ('type' => 'string','required' => false),
                'sort' => array ('type' => 'string','required' => false),
                'order' => array ('type' => 'string','required' => false),
            ),
            "Search the Site",
            'GET',
            false,
            false
        );
    }
    
}
/*
*   to get all posts
*/
function get_all_posts(){
    return json_decode(elgg_view_resource('thewire/everyone'));
}
/*
*   to get my all posts
*/
function get_my_posts($username){
    //$user = get_user_by_username($username);
    return json_decode(elgg_view_resource('thewire/owner',["username"=>$username]));
       // [ 'guid' => $guid]
    //));
}
/*
*   to get friends all posts
*/
function get_friends_posts($username){
    //$user = get_user_by_username($username);
    return json_decode(elgg_view_resource('thewire/friends',["username"=>$username]));
}
/*
*   to get all users
*/
function get_total_users(){
    return  get_number_users(true);
}
/*
*   to get all active users
*/
function get_active_users(){
    return json_decode( get_online_users(array('seconds' => 6000)) );
}
/*
*   to get user profile
*/
function get_user_profile($username){
    return json_decode(elgg_view_resource('profile/view',["username"=>$username]));
}
/*
*   to get user all friends
*/
function get_user_friendList($username){
    //return json_decode(elgg_view_resource('friends',["username"=>$username]));
    //return get_user_friends($username);
    $options = array(
        'relationship' => 'friend',
        'relationship_username' => $username,
        'inverse_relationship' => FALSE,
        'type' => 'user',
        'full_view' => FALSE
        );
    $content = elgg_list_entities_from_relationship($options);
    return json_decode($content);
}
/*
*   to get user all pages
*/
function get_user_pages($username){
    return json_decode(elgg_view_resource('pages/owner',["username"=>$username]));
}
/*
*   to get user all groups
*/
function get_user_groups($username){
    return json_decode(elgg_view_resource('groups/owner',["username"=>$username]));
}
/*
*   to get user all member groups
*/
function get_user_memberGroups($username){
    return json_decode(elgg_view_resource('groups/member',["username"=>$username]));
}
/*
*   to get user all bookmarks
*/
function get_user_bookmarks($username){
    return json_decode(elgg_view_resource('bookmarks/owner',["username"=>$username]));
}
/*
*   to get user all files
*/
function get_user_files($username){
    return json_decode(elgg_view_resource('file/owner',["username"=>$username]));
}
/*
*   add a public post for user
*/
function set_public_post($username){
    // get the form inputs
    $title = 'test post title in API';
    $body = 'test post body in API';
    $tags = string_to_tag_array('tags in API');
    $user = get_user_by_username($username);
    // elgg_create_river_item(array(
    //     'view' => 'river/object/thewire/create',
    //     'action_type' => 'create',
    //     'subject_guid' => 8,
    //     //'object_guid' => 53,
    // ));
    // return true;

    //another
    $access = ACCESS_PUBLIC;
    $text = "test post body in API...";
    if (!$user) {
        throw new InvalidParameterException('registration:usernamenotvalid');
    }
    $return['success'] = false;
    if (empty($text)) {
        $return['message'] = elgg_echo("thewire:blank");
        return $return;
    }
    $access_id = strip_tags($access);
    $guid = thewire_save_post($text, $user->guid, $access_id, "api");
    if (!$guid) {
        $return['message'] = elgg_echo("thewire:error");
        return $return;
    }
    $return['success'] = true;
    return $return;

    //another
    // $username="user4test";
    // $password="test4test";

    // $access_id = ACCESS_PUBLIC;
    // $method = 'site';
    // $parent_guid = null;
    
    // if(elgg_authenticate($username,$password)){
    //      // make sure the post isn't blank
    //     if (empty($body)) {
    //         return elgg_echo("thewire:blank");
    //         //forward(REFERER);
    //     }

    //     //$guid = thewire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method);
    //     $guid = thewire_save_post($body, get_user_by_username($username), $access_id, $parent_guid, $method);
    //     if (!$guid) {
    //         //register_error(elgg_echo("thewire:notsaved"));
    //         //forward(REFERER);
    //         return elgg_echo("thewire:notsaved");
    //     }else{
    //         return $guid;
    //     }
    // }else{
    //     return "user not valid";
    // }

    //another
    // $user = get_user_by_username($username);
    // if (!$user) {
    //     throw new InvalidParameterException('Bad username');
    // }

    // $obj = new ElggObject();
    // $obj->subtype = 'thewire';
    // $obj->owner_guid = $user->guid;
    // $obj->user_guid = $user->guid;
    // $obj->access_id = ACCESS_PUBLIC;
    // $obj->method = 'api';
    // $obj->description = elgg_substr(strip_tags($body), 0, 140);

    // $guid = $obj->save();

    // // add_to_river('river/object/thewire/create',
    // //              'create',
    // //              $user->guid,
    // //              $obj->guid
    // //             );

    

    // elgg_create_river_item(array(
    //     'view' => 'river/object/thewire/create',
    //     'action_type' => 'create',
    //     'subject_guid' => $obj->owner_guid,
    //     'object_guid' => 53,
    // ));
    // return 'success';
}
/*
*   to get search result
*/
function get_search_result($q){
    // elgg_register_rss_link();
    // // register some default search hooks
	// elgg_register_plugin_hook_handler('search', 'object', 'search_objects_hook');
	// elgg_register_plugin_hook_handler('search', 'user', 'search_users_hook');
	// elgg_register_plugin_hook_handler('search', 'group', 'search_groups_hook');

	// // tags and comments are a bit different.
	// // register a search types and a hooks for them.
	// elgg_register_plugin_hook_handler('search_types', 'get_types', 'search_custom_types_tags_hook');
    // elgg_register_plugin_hook_handler('search', 'tags', 'search_tags_hook');
    // elgg_register_plugin_hook_handler('robots.txt', 'site', 'search_exclude_robots');
    $search_type ='all';
     $query = stripslashes($q);
     $_POST["q"]=$q;
    //return elgg_view_resource('search/index');
    $options = [
        'type' => 'object',
        'query' => $query,
        'search_type' => 'all',
        
    ];
    //elgg_register_entity_type('object', 'entity');
    //elgg_unregister_plugin_hook_handler('search:results', 'object', 'search_objects_hook');
    return elgg_register_plugin_hook_handler('search:results', 'object', 'search_objects_hook');
    //return elgg_list_entities($options, 'elgg_search');
    //return elgg_get_entities($options, 'elgg_search');


    // $owner_guid = get_input('owner_guid', ELGG_ENTITIES_ANY_VALUE);
    // $container_guid = get_input('container_guid', ELGG_ENTITIES_ANY_VALUE);
    // $options = [
    //     'type' => 'user',
    //     'query' => 'post',
    //     'fields' => [
    //         'metadata' => ['description'],
    //         'annotations' => ['location'],
    //     ],
    //     // 'sort' => [
    //     //     'property' => 'zipcode',
    //     //     'property_type' => 'annotation',
    //     //     'direction' => 'asc',
    //     // ]
    // ];
    // // set up search params
    // $params = array(
    //     'query' => $query,
    //     'offset' => 0,
    //     'limit' => 2,
    //     'sort' => "relevance",
    //     'order' => 'asc',
    //     'search_type' => $search_type,
    //     'type' => "",
    //     'subtype' => "",
    // //	'tag_type' => $tag_type,
    //     // 'owner_guid' => $owner_guid,
    //     // 'container_guid' => $container_guid,
    // //	'friends' => $friends
    //     'pagination' => ($search_type == 'all') ? FALSE : TRUE
    // );
    // $custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());
    // $results = elgg_trigger_plugin_hook('search', $custom_types, $params, array());
    //return elgg_list_entities($params, 'elgg_search');
    // $url= elgg_get_site_url()."livesearch/users?view=json&q=test";
    // $jsonData = file_get_contents($url);
    // return $jsonData;
    //  Initiate curl
    // $ch = curl_init();
    // // Disable SSL verification
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // // Will return the response, if false it print the response
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // // Set the url
    // curl_setopt($ch, CURLOPT_URL,$url);
    // // Execute
    // $result=curl_exec($ch);
    // // Closing
    // curl_close($ch);
    // return var_dump(json_decode($result, true));
    //$url= elgg_get_site_url()."search?q=".$query."&search_type=".$search_type;
    //return elgg_view_resource($url);
    //return elgg_list_entities($params, 'elgg_search');

    // $options = [
    //     'type'=>'user',
    //     //'search_type' => 'all',
    //     'query' => 'Trento, Italy',
    //     'fields' => [
    //         //'metadata' => ['title', 'description'],
    //         //'annotations' => ['revision'],
    //         'metadata' => ['description'],
    //         'annotations' => ['location'],
    //     ],
    //     'sort' => [
    //         'property' => 'zipcode',
    //         'property_type' => 'annotation',
    //         'direction' => 'asc',
    //     ]
    // ];
    
    // return elgg_list_entities($options, 'elgg_search');
}


/*
*  test......
*  .....
*/
function my_echo($string) {
    return $string;
}

function rest_wire_post($username, $text) {
    $user = get_user_by_username($username);
    if (!$user) {
        throw new InvalidParameterException('Bad username');
    }

    $obj = new ElggObject();
    $obj->subtype = 'thewire';
    $obj->owner_guid = $user->guid;
    // $obj->access_id = ACCESS_PUBLIC;
    // $obj->method = 'api';
    // $obj->description = elgg_substr(strip_tags($text), 0, 140);

    // $guid = $obj->save();

    // add_to_river('river/object/thewire/create',
    //              'create',
    //              $user->guid,
    //              $obj->guid
    //             );
    
    //return 'success';
    //return get_entity_statistics($user->guid);

    $post = elgg_extract('entity', $vars['entity'], FALSE);
    //return json_decode(elgg_list_river());
    return json_decode(elgg_view_resource('thewire/friends'));
    // $text = substr($text, 0, 140);

    // $access = ACCESS_PUBLIC;

    // // returns guid of wire post
    // return thewire_save_post($text, $access, "api");
}

function site_search($q, $offset = 0,$search_type = 'all', $limit = 20, $entity_type = ELGG_ENTITIES_ANY_VALUE, /* $owner_guid = ELGG_ENTITIES_ANY_VALUE, $container_guid = ELGG_ENTITIES_ANY_VALUE, $friends = ELGG_ENTITIES_ANY_VALUE,*/ $entity_subtype = ELGG_ENTITIES_ANY_VALUE, $sort = 'relevance', $order = 'desc')    {

    //Use ElggEntity::toObject() then add whatever other metadata you need
    //$params = new ElggEntity::toObject();
    $query = stripslashes($q);
    $display_query = _elgg_get_display_query($query);
    
    // check that we have an actual query
    if (empty($query) && $query != "0") {
        $return['status'] = true;
        $return['output'] = elgg_echo('search:no_query');
        return $return;
    }
    
    // get limit and offset.  override if on search dashboard, where only 2
    // of each most recent entity types will be shown.
    $limit = ($search_type == 'all') ? 2 : elgg_get_config('default_limit');
    $offset = ($search_type == 'all') ? 0 : $offset;
    
    switch ($sort) {
        case 'relevance':
        case 'created':
        case 'updated':
        case 'action_on':
        case 'alpha':
            break;
    
        default:
            $sort = 'relevance';
            break;
    }
    
    if ($order != 'asc' && $order != 'desc') {
        $order = 'desc';
    }
    
    // set up search params
    $params = array(
        'query' => $query,
        'offset' => $offset,
        'limit' => $limit,
        'sort' => $sort,
        'order' => $order,
        'search_type' => $search_type,
        'type' => $entity_type,
        'subtype' => $entity_subtype,
    //    'tag_type' => $tag_type,
    //    'owner_guid' => $owner_guid,
    //    'container_guid' => $container_guid,
    //    'friends' => $friends
        'pagination' => ($search_type == 'all') ? FALSE : TRUE
    );
    
    $types = get_registered_entity_types();
    $types = elgg_trigger_plugin_hook('search_types', 'get_queries', $params, $types);
    
    $custom_types = elgg_trigger_plugin_hook('search_types', 'get_types', $params, array());
    
    // start the actual search
    $results_html = '';
    
    if ($search_type == 'all' || $search_type == 'entities') {
        // to pass the correct current search type to the views
        $current_params = $params;
        $current_params['search_type'] = 'entities';
    
        // foreach through types.
        // if a plugin returns FALSE for subtype ignore it.
        // if a plugin returns NULL or '' for subtype, pass to generic type search function.
        // if still NULL or '' or empty(array()) no results found. (== don't show??)
        foreach ($types as $type => $subtypes) {
            if ($search_type != 'all' && $entity_type != $type) {
                continue;
            }
    
            if (is_array($subtypes) && count($subtypes)) {
                foreach ($subtypes as $subtype) {
                    // no need to search if we're not interested in these results
                    // @todo when using index table, allow search to get full count.
                    if ($search_type != 'all' && $entity_subtype != $subtype) {
                        continue;
                    }
                    $current_params['subtype'] = $subtype;
                    $current_params['type'] = $type;
    
                    $results = elgg_trigger_plugin_hook('search', "$type:$subtype", $current_params, NULL);
                    if ($results === FALSE) {
                        // someone is saying not to display these types in searches.
                        continue;
                    } elseif (is_array($results) && !count($results)) {
                        // no results, but results searched in hook.
                    } elseif (!$results) {
                        // no results and not hooked.  use default type search.
                        // don't change the params here, since it's really a different subtype.
                        // Will be passed to elgg_get_entities().
                        $results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
                    }
    
                    if (is_array($results['entities']) && $results['count']) {
                        if ($view = search_get_search_view($current_params, 'list')) {
                            $results_html .= elgg_view($view, array(
                                'results' => $results,
                                'params' => $current_params,
                            ));
                        }
                    }
                }
            }
    
            // pull in default type entities with no subtypes
            $current_params['type'] = $type;
            $current_params['subtype'] = ELGG_ENTITIES_NO_VALUE;
    
            $results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
            if ($results === FALSE) {
                // someone is saying not to display these types in searches.
                continue;
            }
    
            if (is_array($results['entities']) && $results['count']) {
                if ($view = search_get_search_view($current_params, 'list')) {
                    $results_html .= elgg_view($view, array(
                        'results' => $results,
                        'params' => $current_params,
                    ));
                }
            }
        }
    }
    
    // call custom searches
    if ($search_type != 'entities' || $search_type == 'all') {
        if (is_array($custom_types)) {
            foreach ($custom_types as $type) {
                if ($search_type != 'all' && $search_type != $type) {
                    continue;
                }
    
                $current_params = $params;
                $current_params['search_type'] = $type;
    
                $results = elgg_trigger_plugin_hook('search', $type, $current_params, array());
    
                if ($results === FALSE) {
                    // someone is saying not to display these types in searches.
                    continue;
                }
    
                if (is_array($results['entities']) && $results['count']) {
                    if ($view = search_get_search_view($current_params, 'list')) {
                        $results_html .= elgg_view($view, array(
                            'results' => $results,
                            'params' => $current_params,
                        ));
                    }
                }
            }
        }
    }
    
    // highlight search terms
    if ($search_type == 'tags') {
        $searched_words = array($display_query);
    } else {
        $searched_words = search_remove_ignored_words($display_query, 'array');
    }
    
    $highlighted_query = search_highlight_words($searched_words, $display_query);
    $highlighted_title = elgg_echo('search:results', array("\"$highlighted_query\""));
    
    if (!$results_html) {
        $return['status'] = false;
        $return['output'] = elgg_echo('No Results');
    } else {
        $return['status'] = true;
        $return['output'] = $results_html;
    }
    
    return $return;
    
}




function my_search_objects_hook($hook, $type, $value, $params) {

	$params['joins'] = (array) elgg_extract('joins', $params, array());
	$params['wheres'] = (array) elgg_extract('wheres', $params, array());
	
	$db_prefix = elgg_get_config('dbprefix');

	$join = "JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid";
	array_unshift($params['joins'], $join);

	$fields = array('title', 'description');
	$where = search_get_where_sql('oe', $fields, $params);
	$params['wheres'][] = $where;
	
	$params['count'] = TRUE;
	$count = elgg_get_entities($params);
	
	// no need to continue if nothing here.
	if (!$count) {
		return array('entities' => array(), 'count' => $count);
	}
	
	$params['count'] = FALSE;
	if (isset($params['sort']) || !isset($params['order_by'])) {
		$params['order_by'] = search_get_order_by_sql('e', 'oe', $params['sort'], $params['order']);
	}
	$params['preload_owners'] = true;
	$entities = elgg_get_entities($params);

	// add the volatile data for why these entities have been returned.
	foreach ($entities as $entity) {
		$title = search_get_highlighted_relevant_substrings($entity->title, $params['query']);
		$entity->setVolatileData('search_matched_title', $title);

		$desc = search_get_highlighted_relevant_substrings($entity->description, $params['query']);
		$entity->setVolatileData('search_matched_description', $desc);
	}

	return array(
		'entities' => $entities,
		'count' => $count,
	);
}

