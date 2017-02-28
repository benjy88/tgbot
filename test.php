<?php
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramOtherException;
use Telegram\Bot\Keyboard\Keyboard;

require 'vendor/autoload.php';

// enlightMyFireBot
$botToken = '258922907:AAEFNo4l4QzETrj3qwNJ_lBSpmnmF0sme3g';

$telegram = new Api($botToken);

//$response = $telegram->sendMessage([
//    'chat_id' => '129442233',
//    'text' => 'Hello World'
//]);

//$messageId = $response->getMessageId();


//$apiKeyBenjy77 = '58fc747e1f1f2e0d52acf52c4cf6ef53'; // see https://v.enl.one/apikey
//$userName = 'benjy77';
//$url = sprintf('https://v.enl.one/api/v2/search?apikey=%s&telegram=%s', $apiKeyBenjy77, $userName);


//$client = new GuzzleHttp\Client();
//$baseEndpoint = 'https://tasks-test.enl.one/api';
//
//$urlOpNew = sprintf('%s/op?apikey=%s', $baseEndpoint, $apiKeyBenjy77);
//$urlOp = sprintf('%s/op/%%s?apikey=%s', $baseEndpoint, $apiKeyBenjy77);
//$urlOps = sprintf('%s/ops?apikey=%s', $baseEndpoint, $apiKeyBenjy77);

// create OP
//$options = [
//    'json' => [
//        'name' => 'abc',
//        'type' => 'other',
//    ]
//];
//$res = $client->request('POST', $urlOpNew, $options);
//echo $res->getStatusCode()."\n";
//echo $res->getBody()."\n";

// details OP
//$res = $client->request('GET', sprintf($urlOp, 30), []);
//echo $res->getStatusCode()."\n";
//$data = json_decode($res->getBody(), true);
//print_r($data);

// delete OP
//$res = $client->request('DELETE', sprintf($urlOp, 29), []);
//echo $res->getStatusCode()."\n";
//echo $res->getBody()."\n";

// list OPs
//$res = $client->request('GET', $urlOps, []);
//echo $res->getStatusCode()."\n";
//echo $res->getBody()."\n";

//exit;

echo 'Starting bot... '."\n\n";

$lastOffset = 0;

while (true) {

    $updates = $telegram->getUpdates(['offset' => $lastOffset + 1, 'limit' => 100, 'timeout' => 20]);

    foreach ($updates as $update) {

        $message = $update->getMessage();
//
        $user = $message->getFrom();
        $username = $user->getUsername();

        $chat = $message->getChat();
        $chatId = $chat->getId();

        $text = $message->getText();

        $lastOffset = $update->getUpdateId();

        echo sprintf("[%s] Got message '%s' from user '%s' in chat #%s\n", $lastOffset, $text, $username, $chatId);
//        print_r($message);

        //        $text = sprintf("OP \"%s\" (#%d) by %s", $data['name'], $data['id'], $data['owner']);


        $reply_markup = Keyboard::make([
            'keyboard' => [['yes', 'no']],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        if ($text) {
            try {
                echo sprintf("Sending '%s' to chat #%s\n", $text, $username, $chatId);
                $response = $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $text,
//                    'reply_markup' => $reply_markup
                ]);
            } catch (TelegramOtherException $e) {
                echo 'Send failed.. ' . "\n";
            }
        }
    }

    sleep(1);
}
