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
    /**
     * Create a new event instance.
     */
    public function __construct($UserID,$LoginType,$data){
        $this->message=$data;
        $this->UserID=$LoginType=="Admin"?"RPC-".$LoginType:$UserID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(){
        return ['rpc-chat-202'];
    }
    public function broadcastAs(){
        return $this->UserID;
    }
}
