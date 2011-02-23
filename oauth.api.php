<?php
// $Id$

/**
 * @file
 * Hooks provided by the OAuth module.
 */

// This is dummy constant as they will be never be parsed. Only here for
// auto completion assist and shows the API possibilities to the programmer.
define(OAUTH_HTTP_METHOD_GET, "GET");
define(OAUTH_HTTP_METHOD_POST, "POST");
define(OAUTH_HTTP_METHOD_PUT, "PUT");
define(OAUTH_HTTP_METHOD_HEAD, "HEAD");
define(OAUTH_HTTP_METHOD_DELETE, "DELETE");

define(OAUTH_SIG_METHOD_HMACSHA1, "HMAC-SHA1");
define(OAUTH_SIG_METHOD_HMACSHA256, "HMAC-SHA256");
define(OAUTH_SIG_METHOD_RSASHA1, "RSA-SHA1");
define(OAUTH_SIG_METHOD_PLAINTEXT, "PLAINTEXT");

/**
 * This constant represents putting OAuth parameters in the request URI.
 * @var string
 */
define(OAUTH_AUTH_TYPE_URI, 0x01);

/**
 * This constant represents putting OAuth parameters as part of the HTTP POST 
 * body.
 * @var string
 */
define(OAUTH_AUTH_TYPE_FORM, 0x02);

/**
 * This constant represents putting OAuth parameters in the Authorization header. 
 * @var string
 */
define(OAUTH_AUTH_TYPE_AUTHORIZATION, 0x03);

/**
 * This constant indicates a NoAuth OAuth request.
 * @var string
 */
define(OAUTH_AUTH_TYPE_NONE, 0x04);

/**
 * Used by Oauth::setReqeustEngine() to set the engine to PHP streams, as 
 * opposed to OAUTH_REQENGINE_CURL for Curl.
 * @var integer
 */
define(OAUTH_REQENGINE_STREAMS, 1);

/**
 * Used by Oauth::setReqeustEngine() to set the engine to Curl, as opposed to 
 * OAUTH_REQENGINE_STREAMS for PHP streams. 
 * @var integer
 */
define(OAUTH_REQENGINE_CURL, 2);

/**
 * Life is good.
 * @var integer
 */
define(OAUTH_OK);

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Identifies a module implementation to OAuth.
 *
 * @return
 *   An associative array with the following keys.
 *
 *   - name: The user friendly name of this provider.
 *   - icon: (Optionnal) An icon for this provider. Relative path from module directory.
 */
function hook_oauth_info() {
  return array(
    'name' => 'OAuth Provider',
    'icon' => 'oauth.png',
    'authentication' => 'https://api.example.org/authenticate',
    'authorization' => 'https://api.example.org/authorize'
  );
}

/**
 * @} End of "addtogroup hooks".
 */