<?php

namespace App\Repositories;

use App\Interfaces\TicketRepositoryInterface;
use App\Models\Ticket;
use App\Models\TicketDiscussion;
use App\Models\TicketHistory;
use Illuminate\Support\Str;
use Auth;

class TicketRepository implements TicketRepositoryInterface {

    public function getAllTicket() {
        return Ticket::all();
    }
    
    public function getTicketsByUserId($user_id) {
        return Ticket::where('user_id', $user_id)->get();
    }

    public function getTicketById($id) {
        return Ticket::findOrFail($id);
    }
    
    public function getTicketByToken($token) {
        return Ticket::where('token', $token)->first();
    }

    public function getAllDiscussions($ticketId) 
    {
        return TicketDiscussion::where('ticket_id', $ticketId)->get();
    }

    public function createDiscussion($ticketId, $request) {
        return TicketDiscussion::create([
            'ticket_id' => $ticketId,
            'user_id' => auth()->user()->id,
            'message' => $request->message,
            'is_admin' => 1
        ]);
    }
    
    public function createDiscussionForUser($ticketId, $request) {
        return TicketDiscussion::create([
            'ticket_id' => $ticketId,
            'message' => $request->message,
            'is_admin' => 0
        ]);
    }

    public function createTicket($request) {
        $prevTicketNumber = Ticket::latest()->first()->ticket_number;
        $token = random_bytes(8);
        $token = bin2hex($token);

        return Ticket::create([
            'ticket_number' => $prevTicketNumber ? $prevTicketNumber + 1: 10000,
            'user_id'       => $request->user_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'order_number'  => $request->order_number,
            'topic'         => $request->topic,
            'question'      => $request->question,
            'token'         => $token,
            'shop_name'     => $request->shop_name,
            'shop_domain'   => $request->shop_domain,
            'status'        => Ticket::STATUS_SOLVED
        ]);
    }

    public function ticketChangeStatus($request, $token)
    {
        $ticket = Ticket::where('token', $token)->first();
        if ($ticket->status === Ticket::STATUS_SOLVED || $ticket->status === Ticket::STATUS_AUTO_CLOSED) {
            // dd(1);
            $ticket->update([
                'status' => Ticket::STATUS_REOPEN,
            ]);
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'status' => Ticket::STATUS_REOPEN
            ]);
        }elseif($request->type === Ticket::STATUS_UNSOLVED) {
            // dd(2);

            $ticket->update([
                'status' => Ticket::STATUS_SOLVED
            ]);
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'status' => Ticket::STATUS_SOLVED
            ]);
        }

        return $ticket;
    }
}
