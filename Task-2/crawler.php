<?php
// Function to fetch webpage content using cURL
function fetchWebpage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Function to parse product details from HTML
function parseProduct($html) {
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    
    $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
    $description = $doc->getElementsByTagName("meta")->item(0)->getAttribute("content");
    $category = $doc->getElementsByTagName("meta")->item(1)->getAttribute("content");
    $price = $doc->getElementsByTagName("meta")->item(2)->getAttribute("content");
    $productUrl = $doc->getElementsByTagName("link")->item(0)->getAttribute("href");
    $imageUrl = $doc->getElementsByTagName("meta")->item(3)->getAttribute("content");

    return [$title, $description, $category, $price, $productUrl, $imageUrl];
}

// Function to write CSV file
function writeCSV($data) {
    $fp = fopen('product_feed.csv', 'w');
    fputcsv($fp, ['Title', 'Description', 'Category', 'Price', 'Product URL', 'Image URL']);
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
}

// Main function to crawl the website
function crawlWebsite($url) {
    $html = fetchWebpage($url);
    preg_match_all('/<a class="product-link" href="([^"]+)"/', $html, $matches);

    $products = [];
    foreach ($matches[1] as $productUrl) {
        $productHtml = fetchWebpage($productUrl);
        $products[] = parseProduct($productHtml);
    }

    writeCSV($products);
    echo "CSV product feed generated successfully.\n";
}

// Start crawling the website
crawlWebsite("https://yourpetpa.com.au/");
?>
