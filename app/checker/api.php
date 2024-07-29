<?php
// Set headers for JSON response and Access Control Allow Origin
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Get email from GET request parameter, sanitize input using htmlentities and set default value as empty string
$requestedEmail = isset($_GET['email']) ? trim(htmlentities($_GET['email'])) : '';

/**
 * Function extractSubstringBetweenTwoStrings
 * @param string $inputString The input string in which we want to find our substring
 * @param string $substringStart The start substring that will be used to determine where our desired substring starts
 * @param string $substringEnd The end substring that will be used to determine where our desired substring ends
 * @return string Substring between two strings or an empty string if not found
 */
function extractSubstringBetweenTwoStrings($inputString, $substringStart, $substringEnd) {
    // Add space at beginning of input string
    $inputStringWithSpaceAtBeginning = ' ' . $inputString;
    
    // Find position of first occurrence of substringStart in input string
    $positionOfSubstringStart = strpos($inputStringWithSpaceAtBeginning, $substringStart);
    
    if ($positionOfSubstringStart === 0) {
        // If substringStart is at the very beginning of the input string, there are no characters before it
        return '';
    }
    
    // Increase position by length of substringStart
    $positionOfSubstringStart += strlen($substringStart);
    
    // Find position of substringEnd after substringStart
    $positionOfSubstringEnd = strpos($inputStringWithSpaceAtBeginning, $substringEnd, $positionOfSubstringStart);
    
    // Calculate difference between positions to get length of substring between substringStart and substringEnd
    $lengthOfSubstring = $positionOfSubstringEnd - $positionOfSubstringStart;
    
    // Extract substring based on calculated values
    $extractedSubstring = substr($inputStringWithSpaceAtBeginning, $positionOfSubstringStart, $lengthOfSubstring);
    
    return $extractedSubstring;
}
function fetch($url){
  $m = curl_init();
  curl_setOPT($m, CURLOPT_URL, $url);
  curl_setopt($m, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($m, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($m);
  return $result;
  curl_close($m);
}
$useragents = explode(PHP_EOL, fetch("./useragents.txt"));
$index = rand(0, count($useragents) - 1);
// Initialize cURL session
$curlSession = curl_init();

// Configure cURL options
curl_setopt($curlSession, CURLOPT_URL, 'https://history.paypal.com/cgi-bin/webscr?cmd=_xclick&xo_node_fallback=true&force_sa=true&upload=1&rm=2&business=' . urlencode($requestedEmail));
curl_setopt($curlSession, CURLOPT_ENCODING, "");
curl_setopt($curlSession, CURLOPT_POST, 0);
curl_setopt($curlSession, CURLOPT_HEADER, 1);
curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curlSession, CURLOPT_COOKIESESSION, 1);
curl_setopt($curlSession, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($curlSession, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('accept-encoding: gzip, deflate, sdch, br', 'accept-language: en-US,en;q=0.8,id;q=0.6,fr;q=0.4', 'upgrade-insecure-requests: 1', 'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36', 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'authority: www.paypal.com', 'cookie: cookie_check=yes; d_id=4467cb5b22aa4edd9fde2b1fdaeddfc01713123309359; nsid=s%3AOf4vgZ8P8qqkiDKSiOqnpWarfYm_ef2Y.PVc%2FWwUX54jqEZuBcda4I5DMnQhkbMrW16mxWLNdylk; TLTDID=63220900028478940730165815541227; DPz73K5mY4nlBaZpzRkjI3ZzAY3QMmrP=S23AANvTJhahr4fmQR7Z81tn_XEpWCtGb_atvdSgzrBgK-h6HwwIF3-zZqjfEEKYLheAZpdyf-1nurgEWHIf3i1X1vGi_qLKA; id_token=; cookie_prefs=T%3D1%2CP%3D1%2CF%3D1%2Ctype%3Dexplicit_banner; _gcl_au=1.1.1924605817.1713962204; ui_experience=login_type%3DEMAIL_PASSWORD%26login_preference%3D; rmuc=; navcmd=_home; consumer_display=USER_HOMEPAGE%3d0%26USER_TARGETPAGE%3d0%26USER_FILTER_CHOICE%3d0%26BALANCE_MODULE_STATE%3d1%26GIFT_BALANCE_MODULE_STATE%3d1%26LAST_SELECTED_ALIAS_ID%3d0%26SELLING_GROUP%3d1%26PAYMENT_AND_RISK_GROUP%3d1%26SHIPPING_GROUP%3d1%26HOME_VERSION%3d1714936779%26MCE2_ELIGIBILITY%3d4294967295; navlns=0.0; cwrClyrK4LoCV1fydGbAxiNL6iG=teHsxkwQNoqIgVqocpmtqeD38dLrvesT-yDOBJi9ZJinAE8u-kBqLQZCP5md6QfoI8ISX8K9c2b9MjbuBhbSFKSNOSHljFgKeqd4vMRt4A-ZCFQ9S5WfTvlJ6EZ6vRA_2MkTwaZHjbDgYAZBWaJWjxjh-bKbSRRcSmWVI_593zZiElIvklCWPp_2OvKPbZTGaSGPb3UvWP1NkcOh9Da4j3RsUMJTM193UsJOC25Jo3AhiS2p6evOqmDKc333FWRS8x4ulvSgd11kj5GsV7Ls_jMFNF-ikC6rAi8QYviUX02lA3a_K74tkLpY4Q9OGSBNHio01FRQ1Kx5SlZooQ5you7C3C8axYS3plr4_yBBAmSj8Bj6Vctkh5jzSfRxlEgMGcQMg45UPWwjiE5Lb2BzjjUOCxBqZRII9rVQ0GBSOOMmshV8uiBWrmnVCe4; enforce_policy=gdpr_v2.1; TLTSID=53030026177739387035781112541094; fn_dt=f6b241909ba24f9998712c5279ba34d3; login_email=abderahmanessayah65%40gmail.com; pi_opt_in925803=true; visitor_id925803-hash=a8d3b15ac2f1eecda237cbc9eb7c35fe9feff3539b17654d09673d50eafff71720c8ad17d3f03ea76fc99acba1ef0ac48d325771; visitor_id925803=3249770684; _ga_FQYH6BLY4K=GS1.1.1717087376.4.0.1717087376.0.0.0; _ga=GA1.2.1967499465.1713962205; _gid=GA1.2.157389005.1717087377; LANG=fr_FR%3BFR; l7_az=dcg16.slc; tsrce=mppnodeweb; ts_c=vr%3Dd270f58318d0aa30c8459651ffe345a5%26vt%3Dcaa8bb6318f0ad11dce7db73fd95ac4d; x-pp-s=eyJ0IjoiMTcxNzA5MjAwNzcyNiIsImwiOiIwIiwibSI6IjAifQ; ts=vreXpYrS%3D1811700007%26vteXpYrS%3D1717093807%26vr%3Dd270f58318d0aa30c8459651ffe345a5%26vt%3Dcaa8bb6318f0ad11dce7db73fd95ac4d%26vtyp%3Dreturn'));
curl_setopt($curlSession, CURLOPT_USERAGENT, $useragents[$index]);
$err = ['error_code' => 400, 'email' => $requestedEmail, 'status' => 'unknown'];
// Execute cURL session and store result
$response = curl_exec($curlSession) or die(json_encode($err));

// Check if location header contains specific string indicating error condition
if (strpos($response, 'div class="message"') !== false) {
    $errorResponse = ['error_code' => 209, 'email' => $requestedEmail, 'status' => 'invalid'];
    echo json_encode($errorResponse);
    exit();
} elseif (strpos($response, 'class="preloader spinner"') !== false) {
    $errorResponse = ['error_code' => 0, 'email' => $requestedEmail, 'status' => 'live'];
    echo json_encode($errorResponse);
    exit();
} else {
    echo $response;
    $successResponse = ['error_code' => 400, 'email' => $requestedEmail, 'status' => 'unknown'];
    echo json_encode($successResponse);
    exit();
}
?>