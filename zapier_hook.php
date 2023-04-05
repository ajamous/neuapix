<?php

/**
 * NeuAPIX WhatsApp Multi-Recipient Message Sender using Pre-defined Templates
 * Author: Ameed Jamous
 * Company: TelecomsXChange
 * Copyright (c) 2023, TelecomsXChange. All rights reserved.
 
 * EXAMPLE CURL REQUEST for this webhook

 curl --location 'http://10.211.56.5/neuapix/zapier_hook.php' \
--header 'X-Secret-Password: LDBb234x02!@' \
--header 'Content-Type: application/json' \
--data-raw '
               {

                "company": "AcmeTest Inc",
                "email": "testemail@domain.com",
                "domain_age": "7",
                "fraud_score": "75"
               }

' 
 */



// Define your secret password
$SECRET_PASSWORD = "MY_PASSWORD";

// Extract the password from the request headers
$password = $_SERVER['HTTP_X_SECRET_PASSWORD'] ?? '';

// Verify that the password is correct
if ($password !== $SECRET_PASSWORD) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // List of recipients

// List of recipients
        $recipients = [
        '+96279********',
        '+195424******', // Add more phone numbers as needed
        ];



    // API URL
    $url = 'https://wa-api.neuapix.com/whatsapp/v3/{{Channel-ID}}/messages';

    // Authorization header value
    $authHeader = 'Bearer {{TOKEN}}';

    // Template details
    $templateName = 'company_new_signup'; // Enter Pre-approved template name
    $templateLanguageCode = 'en';
    $templateLanguagePolicy = 'deterministic';
    $templateParameters = [
        [
            'type' => 'text',
            'text' => $data['company'], // This assumes that Zapier is sending the first parameter in the 'parameter1' field
        ],
        [
            'type' => 'text',
            'text' => $data['email'], // This assumes that Zapier is sending the second parameter in the 'parameter2' field
        ],
        [
            'type' => 'text',
            'text' => $data['domain_age'], // This assumes that Zapier is sending the third parameter in the 'parameter3' field
        ],
        [
            'type' => 'text',
            'text' => $data['fraud_score'], // This assumes that Zapier is sending the fourth parameter in the 'parameter4' field
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
}
?>
