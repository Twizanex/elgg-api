# elgg-api
ELGG plugin for exposing REST/RPC hybrid API.


# Setup elgg-api


## Upload Folders
- upload folder "elgg_with_rest_api" into {yourElggServer}/mod folder
- upload folder "apiadmin-master" into {yourElggServer}/mod folder

## Activate the plugin
- Login admin panel and go to plugins section.
- Activate "elgg_with_rest_api" plugin.
- Activate "apiadmin-master" plugin (that show the name "API Admin" in plugin list).

## Configuration
- Please go to Utilities->API Key Admin section in the right side of the admin panel.
- Click "Generate a new keypair" and generate the keys
- Copy this api key and save.
- use this key in a every API calls with the value of "api_key" as a Key-based authentication.

## How to use the APIs
- To call the APIs, all you need to do is call the expose method in your application.
- For example, if you want to use the user login API, you could make a POST request to the url: https://domain.com/services/api/rest/json/?method=auth.gettoken&username=your_username&password=your_password (where auth.gettoken is one of the APIs listed below) and you should see JSON data like this:
```json
{
    "status": 0,
    "result": {
        "auth_token": "14c20b4499c018a09dde951903464861",
        "api_key": "e12e70b51b61695fe53f18795cf9ece01f76cf92",
        "gcm_sender_id": "",
        "username": "user4test"
    }
}
```
- You can find the list of exposed methods below along with the following information within the API block:
- description: Description of the API to help you understand the purpose of the API.
- function: Function used for the API (Internal - Only used for debugging of error if any).
- parameters: Parameter required to pass after the "https://domain.com/services/api/rest/json/?" url separated by "&".
- call_method: Defines the call_method either as GET or POST.
- require_api_auth: If "true" you have to pass the the api_key that is return from auth.gettoken API as shown above.
- require_user_auth: If "true" you have to pass the the auth_token that is return from auth.gettoken API as shown above.

## List of APIs
- Here have two type of APIs like: Generaic APIs and User APIs.

## Generaic APIs
### 1. login
- method=auth.gettoken 
```json
{
      "description": "This API call lets a user obtain a user authentication token which can be used for authenticating future API calls.
	  Pass it as the parameter auth_token",
      "function": "auth_gettoken",
      "parameters": {
        "username": {
          "type": "string",
          "required": true
        },
        "password": {
          "type": "string",
          "required": true
        }
      },
      "call_method": "POST",
      "require_api_auth": false,
      "require_user_auth": false
    },
```
### 2. get last post
- method=wire.get_posts
```json
{
    "description": "Read latest wire post",
    "function": "wire_get_posts",
    "parameters": {
      "context": {
        "type": "string",
        "required": false,
        "default": "all"
      },
      "limit": {
        "type": "int",
        "required": false
      },
      "offset": {
        "type": "int",
        "required": false
      },
      "username": {
        "type": "string",
        "required": false
      }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for all post -> &context=all
- for my post -> &context=mine
- for friends post -> &context=friends

### 3. number of user
- method=user.number
```json
{
    "description": "number of users",
    "function": "user_number",
    "parameters": {
      "context": {
        "type": "string",
        "required": false,
        "default": "all"
      }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for register user -> &context=all
- for active user -> &context=active

### 4. search (by query string)
- method=search.site
```json
{
  "description": "Search the Site",
  "parameters": {
    "q": {
      "type": "string",
      "required": true
    },
    "offset": {
      "type": "int",
      "required": false
    },
    "search_type": {
      "type": "string",
      "required": false
    },
    "limit": {
      "type": "int",
      "required": false
    },
    "entity_type": {
      "type": "string",
      "required": false
    },
    "entity_subtype": {
      "type": "string",
      "required": false
    },
    "sort": {
      "type": "string",
      "required": false
    },
    "order": {
      "type": "string",
      "required": false
    }
  },
  "call_method": "GET",
  "require_api_auth": false,
  "require_user_auth": false
}
```
- for search from all -> &search_type=all
- for search from post -> &search_type=entities&entity_type=object&entity_subtype=thewire
- for search from users -> &search_type=entities&entity_type=user&entity_subtype=thewire
- for search from group -> &search_type=entities&entity_type=group&entity_subtype=thewire
- for search from pages -> &search_type=entities&entity_type=object&entity_subtype=page

## User APIs
### 1. public profile
- method=user.get_profile
```json
{
    "description": "Get user profile information",
    "function": "user_get_profile",
    "parameters": {
        "username": {
            "type": "string",
            "required": false
        }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
### 2. list of friends
- method=user.get_friends
```json
{
    "description": "list of friends",
    "function": "user_get_friends",
    "parameters": {
        "username": {
            "type": "string",
            "required": false
        },
        "limit": {
            "type": "int",
            "required": false
        },
        "offset": {
            "type": "int",
            "required": false
        }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
### 3. list of pages
- method=page.list
```json
{
    "description": "list o pages",
    "function": "page_list",
    "parameters": {
        "username": {
            "type": "string",
            "required": false
        },
        "limit": {
            "type": "int",
            "required": false
        },
        "offset": {
            "type": "int",
            "required": false
        },
        "sort": {
            "type": "string",
            "required": false,
            "default": "relevance"
        },
        "order": {
            "type": "string",
            "required": false,
            "default": "desc"
        }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
### 4. list of groups
- method=group.get_list
```json
{
    "description": "GET all the groups",
    "function": "group_get_list",
    "parameters": {
    "context": {
        "type": "string",
        "required": true
    },
    "limit": {
        "type": "int",
        "required": false,
        "default": 20
    },
    "offset": {
        "type": "int",
        "required": false,
        "default": 0
    },
    "username": {
        "type": "string",
        "required": false
    },
    "from_guid": {
        "type": "int",
        "required": false,
        "default": 0
    }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for created by user -> &context=mine
- for where user participates -> &context=member

### 5. list of bookmarks
- method=bookmark.get_posts
```json
{
    "description": "GET all the bookmarks",
    "function": "bookmark_get_posts",
    "parameters": {
    "context": {
        "type": "string",
        "required": true
    },
    "limit": {
        "type": "int",
        "required": false,
        "default": 20
    },
    "offset": {
        "type": "int",
        "required": false,
        "default": 0
    },
    "username": {
        "type": "string",
        "required": false
    },
    "from_guid": {
        "type": "int",
        "required": false,
        "default": 0
    }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for user own bookmarks -> &context=mine

### 6. list of files upload by user
- method=file.get_files
```json
{
    "description": "Get file uploaded by all users",
    "function": "file_get_files",
    "parameters": {
    "context": {
        "type": "string",
        "required": true,
        "default": "all"
    },
    "username": {
        "type": "string",
        "required": true
    },
    "limit": {
        "type": "int",
        "required": false,
        "default": 0
    },
    "offset": {
        "type": "int",
        "required": false,
        "default": 0
    },
    "group_guid": {
        "type": "int",
        "required": false,
        "default": 0
    }
    },
    "call_method": "GET",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for user own uploaded files -> &context=mine

### 7. add a post
- method=wire.save_post
```json
{
    "description": "Post a wire post",
    "function": "wire_save_post",
    "parameters": {
    "text": {
        "type": "string",
        "required": true
    },
    "access": {
        "type": "string",
        "required": true
    },
    "wireMethod": {
        "type": "string",
        "required": true
    },
    "username": {
        "type": "string",
        "required": true
    }
    },
    "call_method": "POST",
    "require_api_auth": true,
    "require_user_auth": true
}
```
- for a public post ->  &access=ACCESS_PUBLIC
- for a friends post ->  &access=ACCESS_FRIENDS
- for a signed users post ->  &access=ACCESS_LOGGED_IN
- for a private post ->  &access=ACCESS_PRIVATE
