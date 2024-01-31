<?php

/**
 * Prints a page header
 * @param array $options assotiative array with elements:
 * $title header title,
 * $title2 (optional) header title2,
 * $btnLink (optional) header button link,
 * $btnText (optional) header button text,
 * $btnClass (optional) header button bootstrap color
 * $btnDataAttributes (optional) The data-* attribute of the button
 */
//------------------------------------------------------------
function displayHeader(array $options = []): void
//------------------------------------------------------------
{
    $allowed_keys = array(
        'title' => '',
        'title2' => '',
        'btnLink' => '',
        'btnText' => '',
        'btnClass' => '',
        'btnDataAttributes' => '',
    );

    if ($options) {
        extract($options);

        $keyExists = true;
        foreach ($options as $key => $value) {
            if (!in_array($key, array_keys($allowed_keys))) {
                // echo "key: $key is not allowed<br>";
                $keyExists = false;
            }
        }

        // Show only if $options key exist
        if ($keyExists == true) {
            $btnOrTitle2 = "";
            if (isset($btnText)) {
                $btnOrTitle2 .= '<a href="' . (isset($btnLink) ? $btnLink : "") . '" class="btn btn-' . (isset($btnClass) ? $btnClass : "success") . '" ' . ($btnDataAttributes ?? "") . '>' . (isset($btnText) ? $btnText : "") . '</a>';
            }
            if (isset($title2)) {
                $btnOrTitle2 .= '<p class="m-0">' . $title2 . '</p>';
            }
            echo "\n";
            echo '<div class="container-lg pt-4">';
            echo '<div class="bg-light border-top border-bottom rounded-1 p-2 mb-3">';
            echo '<div class="d-flex flex-wrap align-items-center justify-content-between">';
            echo '<h3 class="mb-0 me-2 text-muted">' . (isset($title) ? $title : "") . '</h3>';
            echo $btnOrTitle2;
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "\n";
        echo '<div class="container-lg pt-4">';
        echo '<div class="bg-light border-top border-bottom rounded-1 p-2 mb-3">';
        echo '<div class="d-flex flex-wrap align-items-center justify-content-center">';
        echo '<p class="mb-0 me-2 text-danger">Dynamic Header options are not set!</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Display Message if data was not found
 * @param string $text for showing the message
 * @param string $backBtnUrl url for the button to navigate
 * @return void
 */
//------------------------------------------------------------
function displayNoDataBox(string $text, string $backBtnUrl = ""): void
//------------------------------------------------------------
{
    $btn = '<a href="' . $backBtnUrl . '" class="btn btn-secondary btn-bloc mt-4 mb-2"">
                <i class="fas fa-angle-double-left ml-1"></i> Go Back
            </a>';

    echo '<div class="container-lg pt-4">';
    echo '<div class="card text-center border-2 text-muted">';
    echo '<div class="card-body bg-light h-100">';
    echo '<h2 class="card-title">';
    echo '<i class="fas fa-info-circle fa-2x"></i>';
    echo '</h2>';
    echo '<div class="card-text text-black-50 mt-3">';
    echo '<h2>' . $text . '</h2>';
    echo '</div>';
    echo $backBtnUrl !== "" ? $btn : "";
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
