<?php

/**
 * Prints a page header 
 * @param array $args assotiative array with elements: 
 * $title header title,
 * $title2 (optional) header title2,
 * $btnLink (optional) header button link,
 * $btnText (optional) header button text,
 * $btnClass (optional) header button bootstrap color
 */
//------------------------------------------------------------
function showHeading(array $args = []): void
//------------------------------------------------------------
{
    $allowed_keys = array('title' => '', 'title2' => '', 'btnLink' => '', 'btnText' => '', 'btnClass' => '');


    if ($args) {
        extract($args);

        $keyExists = true;
        foreach ($args as $key => $value) {
            if (!in_array($key, array_keys($allowed_keys))) {
                // echo "key: $key is not allowed<br>";
                $keyExists = false;
            }
        }

        // Show only if $args key exist
        if ($keyExists == true) {
            $btnOrTitle2 = "";
            if (isset($btnText)) {
                $btnOrTitle2 .= '<a href="' . (isset($btnLink) ? $btnLink : "") . '" class="btn btn-' . (isset($btnClass) ? $btnClass : "") . '">' . (isset($btnText) ? $btnText : "") . '</a>';
            }
            if (isset($title2)) {
                $btnOrTitle2 .= '<p class="m-0">' . $title2 . '</p>';
            }
            echo '<div class="container-lg pt-4">
                    <div class="bg-light border-top border-bottom rounded-1 p-2 mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <h3 class="mb-0 me-2 text-muted">' . (isset($title) ? $title : "") . '</h3>
                            ' . $btnOrTitle2 . '
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo '<div class="bg-light border-top border-bottom p-1 mb-3">
                <div class="d-flex flex-wrap align-items-center justify-content-center">
                    <p class="mb-0 me-2 text-danger">Heading params not set!</p>
                </div>
            </div>';
    }
}

/**
 * Display Message if no data
 * @param string $text for showing the message
 * @param string $backBtnUrl url for the button to navigate
 * @return void
 */
//------------------------------------------------------------
function showNoDataBox(string $text, string $backBtnUrl = ""): void
//------------------------------------------------------------
{
    $btn = '<a href="' . $backBtnUrl . '" class="btn btn-secondary btn-bloc mt-4 mb-2"">
            <i class="fas fa-angle-double-left ml-1"></i> Go Back
        </a>';

    echo '<div class="container-lg pt-4">
            <div class="card text-center border-2 text-muted">
                <div class="card-body bg-light h-100">
                    <h2 class="card-title">
                        <i class="fas fa-info-circle fa-2x"></i>
                    </h2>
                    <div class="card-text text-black-50 mt-3">
                        <h2>' . $text . '</h2>
                    </div>
                    ' . ($backBtnUrl !== "" ? $btn : "") . '
                </div>
            </div>
        </div>';
}
