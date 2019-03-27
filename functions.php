<?php
function websiteName()
{
    return "Gold Palace";
}

function session_start_safe()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

function replaceFirst($replace_this, $with_this, $original)
{
    $pos = strpos($original, $replace_this);
    if ($pos !== false) {
        $original = substr_replace($original, $with_this, $pos, strlen($replace_this));
    }
    return $original;
}

function replaceLast($replace_this, $with_this, $original)
{
    $pos = strrpos($original, $replace_this);
    if ($pos !== false) {
        $original = substr_replace($original, $with_this, $pos, strlen($replace_this));
    }
    return $original;
}

// To get whole url and not just the path
function url()
{
    return urlFront() . $_SERVER['REQUEST_URI'];
}

function urlFront()
{
    if (!isset($_SERVER['HTTP_HOST'])) {
        return 'https://goldpalace.us';
    }
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }

    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

function getPrevRoute($request)
{
    // Get route that brought user here
    $refererHeader = $request->getHeader('HTTP_REFERER');
    $back = null;
    if ($refererHeader) {
        // Extract referer value
        $referer = array_shift($refererHeader);
        if ($referer != url()) {
            // if the new route isnt the same as the current
            $back = replaceFirst(urlFront(), '', $referer);
        }
    }
    return $back;
}

function getCurrentDateTime()
{
    $dt = new DateTime();
    $dt->setTimezone(new DateTimeZone("America/Chicago"));
    return $dt;
}

function getCurrentDate()
{
    $today = getCurrentDateTime();
    $today->setTime(0, 0);
    return $today;
}

function getCurrentTime()
{
    return getCurrentDateTime()->getTimestamp();
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function startsWith($original, $portion)
{
    return strncmp($original, $portion, strlen($portion)) === 0;
}

function getUserIP()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
