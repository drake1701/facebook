<?php
/**
 * Script to post to facebook, main file.
 *
 * @author      Dennis Rogers <dennis@drogers.net>
 * @address     www.drogers.net
 */

require_once __DIR__ . '/fb.php';

$token = $_SESSION['facebook_access_token'];

if(!isset($token) || empty($token)) {
    
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'publish_actions', 'user_managed_groups']; // optional
    $loginUrl = $helper->getLoginUrl('http://fb.drogers.net/login-callback.php', $permissions);
    
    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    
    exit;
}

// Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($token);

try {
    $response = $fb->sendRequest(
        'POST',
        '/'.$groupId.'/feed',
        array (
            'message' => '867-5309'
        )
    );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$posts = $response->getGraphObject()->uncastItems();
$post = array_pop($posts);
list($groupId, $postId) = explode('_', $post);
?>
<a href="https://www.facebook.com/groups/<?php echo $groupId ?>/permalink/<?php echo $postId ?>/">New Post</a>
