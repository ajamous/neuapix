<?php

/**
 * NeuAPIX WhatsApp Multi-Recipient Message Sender using Pre-defined Templates
 * Author: Ameed Jamous
 * Company: TelecomsXChange
 * Copyright (c) 2023, TelecomsXChange. All rights reserved.
 */


// List of recipients
$recipients = [
    '+1954240xxxx',
    '+919988xxxxxxxx', // Add more phone numbers as needed
];

// API URL
$url = 'https://wa-api.neuapix.com/whatsapp/v3/{{NeuAPIX-Channel-ID}}/messages';

// Authorization header value
$authHeader = 'Bearer {{TOKEN}}';

// Template details
$templateName = '{{Enter Template Name}}';
$templateLanguageCode = 'en';
$templateLanguagePolicy = 'deterministic';
$templateParameters = [
    [
        'type' => 'text',
        'text' => 'AcmeTest Inc',
    ],
    [
        'type' => 'text',
        'text' => 'testemail@domain.com',
    ],
    [
        'type' => 'text',
        'text' => '7',
    ],
    [
        'type' => 'text',
        'text' => '75',
    ],
];

// Sleep duration (in seconds)
$sleepDuration = 1;

// Send the message to each recipient
foreach ($recipients as $recipientPhoneNumber) {
    $payload = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => $recipientPhoneNumber,
        'type' => 'template',
        'template' => [
            'name' => $templateName,
            'language' => [
                'code' => $templateLanguageCode,
                'policy' => $templateLanguagePolicy,
            ],
            'components' => [
                [
                    'type' => 'body',
                    'parameters' => $templateParameters,
                ],
            ],
        ],
    ];


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

// Get the HTTP status code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Print the response and the HTTP status code
echo "Response: " . $response . "\n";
echo "HTTP Code: " . $httpCode . "\n";

// Close cURL
curl_close($ch);

// Sleep for the specified duration
sleep($sleepDuration);
}

?>
