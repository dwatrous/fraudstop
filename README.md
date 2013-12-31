fraudstop
=========

FraudStop is a RESTful credit card fraud detection service: https://fraudstop.simplecreditcardpayments.com/

This repository contains libraries for accessing the fraudstop service.

Below is an example usage for PHP

```php
// create request object
$cardhash = array("cardhash" => "098f6bcd4621d373cade4e832627b4fa");
$cardhash_json = json_encode($cardhash);
$ip_address = "1.2.3.4";

// get transaction count
$transaction_count = get_transaction_count($ip_address, $cardhash_json)

// print transaction attempts
print($transaction_count);
```

cardhash in the above example should be a hashed value created using some unique values about the credit card being attempted. For example, if might include the last four of the card and the expiration date. The purpose is to detect multiple attempts from a single IP address with many different cards.