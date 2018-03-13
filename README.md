# elgg-api
ELGG plugin for exposing REST API


# Setup elgg-api


## Upload Folders
- upload folder "apiadmin-master" into {yourElggServer}/mod folder
- upload folder "hello" into {yourElggServer}/mod folder
- upload folder "oauth_api-master" into {yourElggServer}/mod folder


# Setup API

## Activate those plugins
- Login admin panel and go to plugins section.
- Activate "Web services" plugin.
- Activate "apiadmin-master" plugin.
- Activate "hello" plugin.

## Configuration
- Please go to Utilities->API Key Admin section in the right side of the admin panel.
- Click "Generate a new keypair" and generate the keys
- Copy this api key and save.
- use this key in a every API calls with the value of "api_key" as a Key-based authentication.

