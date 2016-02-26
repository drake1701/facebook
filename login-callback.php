<?php
/**
 * Login callback script
 *
 * @author      Dennis Rogers <dennis@drogers.net>
 * @address     www.drogers.net
 */

require_once __DIR__ . '/fb.php';

$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  header('Location: http://fb.drogers.net/');
}