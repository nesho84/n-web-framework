<?php

/**
 * Prints array in nicer format
 * @param array $var array to print
 */
//------------------------------------------------------------
function dd(array $var): void
//------------------------------------------------------------
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die;
}

/**
 * Prints array in nicer format
 * @param array $var array to print
 */
//------------------------------------------------------------
function dd_print(array $var): void
//------------------------------------------------------------
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

/**
 * Force redirect to ignore php error 'headers already sent...'
 * @param string $url of the page
 * @return void
 */
//------------------------------------------------------------
function redirect(string $url): void
//------------------------------------------------------------
{
    header("Location: $url");
}

/**
 * Force redirect to ignore php error 'headers already sent...'
 * @param string $url of the page
 * @return void
 */
//------------------------------------------------------------
function forceRedirect(string $url): void
//------------------------------------------------------------
{
    if (headers_sent()) {
        echo ("<script>location.href='$url'</script>");
    } else {
        header("Location: $url");
    }
}

/**
 * Get's the current page(url) from the url
 * @param array $url url of the page
 * @return void if the $url matches
 */
//------------------------------------------------------------
function activePage(array $url): void
//------------------------------------------------------------
{
    // Get page url 
    $page = isset($_GET['url']) ? $_GET['url'] : '/';
    $page = filter_var($page, FILTER_SANITIZE_URL);

    $page_parts = explode("/", $page);

    foreach ($page_parts as $u) {
        // Route with {id} - Get the id from the url - (ex. post/33)
        if (is_numeric($u)) {
            // replace it with {id} to match the route - (ex. post/{id})
            $page = str_replace($u, '{id}', $page);
        }
        // Route with {slug} - Get the url slug - (ex. post/this-is-a-post) but ignore about-us page
        if (strpos($u, "-") && $u != "about-us") {
            // replace it with {slug} to match the route - (ex. post/{slug})
            $page = str_replace($u, '{slug}', $page);
        }
    }

    foreach ($url as $u) {
        if ($u === $page) {
            echo 'active';
        }
    }
}
