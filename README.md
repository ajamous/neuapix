# NeuAPIX WhatsApp Multi-Recipient Message Sender 💬

This PHP script allows you to send a WhatsApp message to multiple recipients using the NeuAPIX API. It makes an API request for each recipient with a configurable sleep duration between the requests. The script can be used as a webhook to automatically send messages when an event occurs. 🚀

## Prerequisites

- PHP 7.0 or higher
- A registered business phone number, channel ID, and API token from [NeuAPIX](https://developer.neuapix.com/)

## Setup

1. Clone or download this repository.
2. Open `whatsapp_multi_recipient_sender.php` in your favorite text editor.
3. Edit the `$recipients` array and add the phone numbers you want to send messages to.
4. Replace the `$authHeader` variable value with your NeuAPIX API token.
5. (Optional) Adjust the `$sleepDuration` variable value to set the sleep duration between API requests (in seconds).
6. Update the API URL with your correct channel ID.

## Usage

Run the script using the PHP command line interface, or use it as a webhook in your application:



