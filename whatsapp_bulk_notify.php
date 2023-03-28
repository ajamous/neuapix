<?php

/**
 * NeuAPIX WhatsApp Multi-Recipient Message Sender
 * Author: Ameed Jamous
 * Company: TelecomsXChange
 * Copyright (c) 2023, TelecomsXChange. All rights reserved.
 */


// List of recipients
$recipients = [
    '+195424054XX',
    '+96279825XXXX', // Add more phone numbers as needed
];

// API URL
$url = 'https://wa-api.neuapix.com/whatsapp/v3/{{channel-id}}/messages';

// Message body
//$messageBody = 'Hello  Admin, Customer: Acme Inc. - Main Email: john-doe@acmeinc.com has completed sign up form successfully,  Domain Age: 7 months ago,  Fraud score: 85. Please review carefully before approving the account.';

// Get the message body from the query string
// https://yourserver.com/whatsapp_multi_recipient_sender.php?messageBody=Your%20custom%20message%20here

$messageBody = isset($_GET['messageBody']) ? $_GET['messageBody'] : ''; 

// Authorization header value
$authHeader = 'Bearer {{TOKEN}}';

// Sleep duration (in seconds)
$sleepDuration = 1;


// Prepare the message payload using text mode "text mode" which means the user must have initiated a conversation already with your whatsapp business number.
foreach ($recipients as $recipient) {
    $payload = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => $recipient,
        'type' => 'text',
        'text' => [
            'body' => $messageBody,
        ],
    ];

    // Send the message
    sendMessage($url, $authHeader, $payload);
  
    // Sleep between requests
    sleep($sleepDuration);
}

function sendMessage($url, $authHeader, $payload)
{
    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $authHeader,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL
    curl_close($ch);

    // Return the response (optional)
    return $response;
}
