<?php

namespace App\Livewire;

use App\Events\ChatMessage;
use Livewire\Component;

class Chat extends Component
{

    public $textvalue = '';
    public $chatLog = [];

    public function getListeners()
    {
        return [
            "echo-private:chat-channel,ChatMessage" => 'notifyNewMessage'
        ];
    }

    public function notifyNewMessage($message)
    {
        array_push($this->chatLog, $message['chat']);
    }

    public function send()
    {
        if (!auth()->check()) {
            abort(403, 'You must be logged in to send messages');
        }

        if (trim(strip_tags($this->textvalue)) == "") {
            return;
        }

        array_push($this->chatLog, [
            'selfmessage' => true,
            'username' => auth()->user()->username,
            'textvalue' => strip_tags($this->textvalue),
            'avatar' => auth()->user()->avatar
        ]);

        broadcast(new ChatMessage([
            'selfmessage' => false,
            'username' => auth()->user()->username,
            'textvalue' => strip_tags($this->textvalue),
            'avatar' => auth()->user()->avatar
        ]))->toOthers();

        $this->textvalue = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
