<?php

namespace EcomPHP\Shopee\Tests\Resources;

use EcomPHP\Shopee\Client;
use EcomPHP\Shopee\Resources\Chat;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class ChatTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|Client
     */
    private $client;

    /**
     * @var Chat
     */
    private $chat;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->chat = new Chat();
        $this->chat->useApiClient($this->client);
    }

    public function testGetMessage()
    {
        $conversationId = 12345;
        $params = ['offset' => 0, 'page_size' => 20];
        $expectedParams = ['conversation_id' => $conversationId, 'offset' => 0, 'page_size' => 20];
        $expectedResponse = ['messages' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'sellerchat/get_message', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->getMessage($conversationId, $params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendMessage()
    {
        $toId = 12345;
        $messageType = 'text';
        $content = 'Hello, this is a test message';
        $businessType = 0;
        $conversationId = 0;
        $expectedResponse = ['message_id' => 67890];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/send_message', 
                [
                    RequestOptions::JSON => [
                        'to_id' => $toId,
                        'message_type' => $messageType,
                        'content' => ['text' => $content]
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->sendMessage($toId, $messageType, $content, $businessType, $conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendMessageWithContentArray()
    {
        $toId = 12345;
        $messageType = 'text';
        $content = ['text' => 'Hello, this is a test message'];
        $businessType = 0;
        $conversationId = 0;
        $expectedResponse = ['message_id' => 67890];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/send_message', 
                [
                    RequestOptions::JSON => [
                        'to_id' => $toId,
                        'message_type' => $messageType,
                        'content' => $content
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->sendMessage($toId, $messageType, $content, $businessType, $conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendMessageWithBusinessType()
    {
        $toId = 12345;
        $messageType = 'text';
        $content = 'Hello, this is a test message';
        $businessType = 11;
        $conversationId = 67890;
        $expectedResponse = ['message_id' => 67890];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/send_message', 
                [
                    RequestOptions::JSON => [
                        'to_id' => $toId,
                        'message_type' => $messageType,
                        'content' => ['text' => $content],
                        'business_type' => $businessType,
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->sendMessage($toId, $messageType, $content, $businessType, $conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetConversationList()
    {
        $params = ['offset' => 0, 'page_size' => 20];
        $expectedParams = [
            'direction' => 'latest',
            'type' => 'all',
            'offset' => 0,
            'page_size' => 20
        ];
        $expectedResponse = ['conversation_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'sellerchat/get_conversation_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->getConversationList($params);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetConversationListWithDefaultParams()
    {
        $expectedParams = [
            'direction' => 'latest',
            'type' => 'all'
        ];
        $expectedResponse = ['conversation_list' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'sellerchat/get_conversation_list', 
                [
                    RequestOptions::QUERY => $expectedParams
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->getConversationList();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetOneConversation()
    {
        $conversationId = 12345;
        $businessType = 11;
        $expectedResponse = ['conversation' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'sellerchat/get_one_conversation', 
                [
                    RequestOptions::QUERY => [
                        'conversation_id' => $conversationId,
                        'business_type' => $businessType
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->getOneConversation($conversationId, $businessType);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetOneConversationWithDefaultBusinessType()
    {
        $conversationId = 12345;
        $expectedResponse = ['conversation' => []];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'GET', 
                'sellerchat/get_one_conversation', 
                [
                    RequestOptions::QUERY => [
                        'conversation_id' => $conversationId,
                        'business_type' => 0
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->getOneConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteConversation()
    {
        $conversationId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/delete_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->deleteConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testGetUnreadConversationCount()
    {
        $expectedResponse = ['unread_count' => 5];

        $this->client->expects($this->once())
            ->method('call')
            ->with('GET', 'sellerchat/get_unread_conversation_count')
            ->willReturn($expectedResponse);

        $result = $this->chat->getUnreadConversationCount();

        $this->assertEquals($expectedResponse, $result);
    }

    public function testPinConversation()
    {
        $conversationId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/pin_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->pinConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUnpinConversation()
    {
        $conversationId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/unpin_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->unpinConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testReadConversation()
    {
        $conversationId = 12345;
        $lastReadMessageId = 67890;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/read_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId,
                        'last_read_message_id' => $lastReadMessageId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->readConversation($conversationId, $lastReadMessageId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUnreadConversation()
    {
        $conversationId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/unread_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->unreadConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testUploadImage()
    {
        $image = __DIR__ . '/../../phpunit.xml'; // Using an existing file for the test
        $expectedResponse = ['image_url' => 'https://example.com/image.jpg'];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/upload_image', 
                $this->callback(function($options) {
                    if (!isset($options[RequestOptions::MULTIPART])) {
                        return false;
                    }

                    $multipart = $options[RequestOptions::MULTIPART];

                    return count($multipart) === 1
                        && $multipart[0]['name'] === 'file'
                        && $multipart[0]['filename'] === 'image.jpg'
                        && is_string($multipart[0]['contents']);
                })
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->uploadImage($image);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testSendAutoreplyMessage()
    {
        $toId = 12345;
        $content = 'Hello, this is an autoreply message';
        $expectedResponse = ['message_id' => 67890];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/send_autoreply_message', 
                [
                    RequestOptions::JSON => [
                        'to_id' => $toId,
                        'content' => $content
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->sendAutoreplyMessage($toId, $content);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testMuteConversation()
    {
        $conversationId = 12345;
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/mute_conversation', 
                [
                    RequestOptions::JSON => [
                        'conversation_id' => $conversationId
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->muteConversation($conversationId);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testDeleteMessage()
    {
        $messageId = 12345;
        $messageType = 'text';
        $expectedResponse = ['success' => true];

        $this->client->expects($this->once())
            ->method('call')
            ->with(
                'POST', 
                'sellerchat/delete_message', 
                [
                    RequestOptions::JSON => [
                        'message_id' => $messageId,
                        'message_type' => $messageType
                    ]
                ]
            )
            ->willReturn($expectedResponse);

        $result = $this->chat->deleteMessage($messageId, $messageType);

        $this->assertEquals($expectedResponse, $result);
    }
}
