<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class chatApp implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $UserID;
    public function __construct($UserID,$data){
        $this->message=$data;
        $this->UserID=$UserID;
    }
    public function broadcastOn(){
        return ['rpc-chat-582'];
    }
    public function broadcastAs(){
        return $this->UserID;
    }
}
