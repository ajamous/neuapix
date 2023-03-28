/**
 * NeuAPIX WhatsApp Multi-Recipient Message Sender - NodeJS example
 *
 * Author: Ameed Jamous
 * Company: TelecomsXChange
 * Copyright (c) 2023, TelecomsXChange. All rights reserved.
 */

const axios = require('axios');

// List of recipients
const recipients = [
  '+1954240xxxx',
  '+97154xxxxxxx', // Add more phone numbers as needed
];

// API URL
const url = 'https://wa-api.neuapix.com/whatsapp/v3/{{channel-id}}/messages';

// Message body
const messageBody =
  'Hello NTX Admin, Customer: Acme Inc LLC - Main Email:john-doe@acme.com has completed sign up form successfully, Lead Domain Age: 7 months ago, Lead fraud score: 85. Please review carefully before approving the account.';

// Authorization header value
const authHeader = 'Bearer {{TOKEN}}';

// Sleep duration (in milliseconds)
const sleepDuration = 1000;

// Send messages to recipients
(async () => {
  for (const recipient of recipients) {
    const payload = {
      messaging_product: 'whatsapp',
      recipient_type: 'individual',
      to: recipient,
      type: 'text',
      text: {
        body: messageBody,
      },
    };

    await sendMessage(url, authHeader, payload);
    await sleep(sleepDuration);
  }
})();

async function sendMessage(url, authHeader, payload) {
  try {
    const response = await axios.post(url, payload, {
      headers: {
        Authorization: authHeader,
        'Content-Type': 'application/json',
      },
    });

    console.log(`Message sent to ${payload.to}. Response: ${response.status}`);
  } catch (error) {
    console.error(`Error sending message to ${payload.to}:`, error.message);
  }
}

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}
