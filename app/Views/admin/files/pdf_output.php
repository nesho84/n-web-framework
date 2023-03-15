<?php

// Include the dompdf library
require_once(LIBRARY_PATH . '/dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

// Get the customer ID from the URL query string
$id = $_GET['id'];

// Hardcoded values
$customer_name = "Neshat Ademi";
$customer_email = "ademi.neshat@gmail.com";
$customer_address = "some address";
$total = 900;

// Orders array
$orders = array(
    array("product_name" => "Cookies", "quantity" => 3, "price" => 33),
    array("product_name" => "Milk", "quantity" => 2, "price" => 45),
    array("product_name" => "Bread", "quantity" => 1, "price" => 12),
);

// Start HTML output
$HTML = '<!DOCTYPE html>';
$HTML .= '<html>';
$HTML .= '<head>';
$HTML .= '<meta charset="utf-8" />';
$HTML .= '<meta name="viewport" content="width=device-width, initial-scale=1" />';
$HTML .= '<title>A simple, clean, and responsive HTML invoice template</title>';
$HTML .= '<style>';
$HTML .= '
    * {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    h1 {
        text-align: center;
        font-size: 28px;
        padding-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f5f5f5;
        border-bottom: 3px solid #ddd;
        text-align: right;
    }

    td {
        vertical-align: top;
        text-align: right;
    }

    .invoice-info {
        clear: both; 
        position: relative;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .invoice-info__left {
        position: absolute; 
        left: 0pt; 
    }

    .invoice-info__right {
        text-align: right;
    }

    .customer-info {
        margin-bottom: 20px;
    }

    .customer-info__heading {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .total-row-wrapper {
        border: none;
    }

    .total-row {
        font-weight: bold;
        text-align: right;
    }
    
    .footer {
        border-top: 1px solid #ddd;
        margin-top: 40px;
        padding-top: 10px;
        text-align: center;
        font-size: 16px;
        color: #777;
    }

';
$HTML .= '</style>';
$HTML .= '</head>';
$HTML .= '<body>';

// Logo
//Getting image
$image = file_get_contents(APPROOT . '/public/images/logo1.png');
$dataBase64 = base64_encode($image);
$imgpath = '<img src="data:image/png;base64, ' . $dataBase64 . '">';

$HTML .= '<div>' . $imgpath . '</div>';

// Add customer and order details
$HTML .= '<h1>Invoice</h1>';

$HTML .= '<div class="invoice-info">';
$HTML .= '<div class="invoice-info__left">';
$HTML .= '<p>Date: ' . date('d-m-Y') . '</p>';
$HTML .= '<p>Invoice Number: INV-' . $id . '</p>';
$HTML .= '</div>';

$HTML .= '<div class="customer-info invoice-info__right">';
$HTML .= '<h2 class="customer-info__heading">Customer Information</h2>';
$HTML .= '<p>' . $customer_name . '</p>';
$HTML .= '<p>' . $customer_email . '</p>';
$HTML .= '<p>' . $customer_address . '</p>';
$HTML .= '</div>';
$HTML .= '</div>';

$HTML .= '<table>';
$HTML .= '<thead>';
$HTML .= '<tr>';
$HTML .= '<th>Product</th>';
$HTML .= '<th>Quantity</th>';
$HTML .= '<th>Price</th>';
$HTML .= '<th>Total</th>';
$HTML .= '</tr>';
$HTML .= '</thead>';
$HTML .= '<tbody>';

$total = 0;

foreach ($orders as $order) {
    $product_name = $order["product_name"];
    $quantity = $order["quantity"];
    $price = $order["price"];
    $total_price = $quantity * $price;

    $HTML .= '<tr>';
    $HTML .= '<td>' . $product_name . '</td>';
    $HTML .= '<td>' . $quantity . '</td>';
    $HTML .= '<td>' . $price . '</td>';
    $HTML .= '<td>' . $total_price . '</td>';
    $HTML .= '</tr>';

    $total += $total_price;
}

$HTML .= '<tr>';
$HTML .= '<td colspan="3" class="total-row-wrapper">';
$HTML .= '<td class="total-row">Total: $' . $total . '</td>';
$HTML .= '</tr>';

$HTML .= '</tbody>';
$HTML .= '</table>';

// Add footer
$HTML .= '<div class="footer">';
$HTML .= '<p>Thank you for your business!</p>';
$HTML .= '</div>';

// End HTML output
$HTML .= '</body>';
$HTML .= '</html>';


//Setting options
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('dpi', '120');
$options->set('enable_html5_parser', true);
$options->set('tempDir', 'D:\xampp\htdocs\n-web-framework\public\temp\\');

// Generate the PDF file
$dompdf = new Dompdf($options);
$dompdf->loadHtml($HTML);
$dompdf->setPaper('A4', 'portrait');

// Output the PDF directly to the browser
$dompdf->render();
ob_end_clean();
$dompdf->stream("invoice.pdf", array("Attachment" => 0));
