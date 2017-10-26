<?php

define('FACEBOOK_OAUTH_VERSION', 'v2.10');
define('FACEBOOK_CLIENT_ID', '1285553021514920');
define('FACEBOOK_CLIENT_SECRET', 'ba07379be1cc5d831b6d05326f4e8e03');
define('FACEBOOK_HTTP_HOST', 'http://local.dev/');
define('FACEBOOK_REDIRECT_URI', FACEBOOK_HTTP_HOST);
define('FACEBOOK_OAUTH_URL', 'https://www.facebook.com/' . FACEBOOK_OAUTH_VERSION . '/dialog/oauth?');
define('FACEBOOK_TOKEN_URL', 'https://graph.facebook.com/' . FACEBOOK_OAUTH_VERSION . '/oauth/access_token?');
define('FACEBOOK_USER_INFO_URL', 'https://graph.facebook.com/me?fields=&fields=id,email,cover,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified&access_token=');
define('FACEBOOK_USER_PICTURE_URL', 'https://graph.facebook.com/{user-id}/picture?width=9999');
define('FACEBOOK_STATE', md5(uniqid(rand(), TRUE)));