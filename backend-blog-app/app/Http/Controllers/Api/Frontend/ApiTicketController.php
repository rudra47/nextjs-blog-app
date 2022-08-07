<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\TicketRepositoryInterface;
use App\Http\Requests\Ticket\DiscussionCreateRequest;
use App\Models\User;

class ApiTicketController extends Controller
{
    private $ticketRepository;
    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function ticket_history($user_id)
    {
        $response =$this->ticketRepository->getTicketsByUserId($user_id);

        return response()->json($response);
    }

    public function ticketStore(Request $request)
    {
        $response = $this->ticketRepository->createTicket($request);
        
        $data = [
            'id'            => $response->id,
            'ticket_number' => $request->ticket_number,
            'name'          => $request->name,
            'email'         => $request->email,
            'order_number'  => $request->order_number,
            'topic'         => $request->topic,
            'question'      => $request->question,
            'token'         => $response->token,
            'shop_domain'   => $request->shop_domain,
            'created_at'    => $response->created_at->format('H:ia d M, Y'),
        ];

        \Mail::to("info@monsterlab.com")->send(new \App\Mail\TicketMailFromFrontend($data));
        \Mail::to($request->email)->send(new \App\Mail\TicketConfirmation($data));

        return response()->json($response);
    }

    public function ticketResponse($token)
    {
        $ticket = $this->ticketRepository->getTicketByToken($token);
        return response()->json([
            'ticket'      => $ticket,
            'discussions' => $this->ticketRepository->getAllDiscussions($ticket->id),
        ]);
    }

    public function ticketResponseAction(Request $request, $ticketId)
    {
        $response = $this->ticketRepository->createDiscussionForUser($ticketId, $request);
        $ticket = $this->ticketRepository->getTicketById($ticketId);
        $data = [
            'id'            => $ticket->id,
            'subject'       => $ticket->topic,
            'reply'         => $request->message,
            'ticket_number' => $ticket->ticket_number,
            'name'          => $ticket->name,
            'email'         => $ticket->email,
            'order_number'  => $ticket->order_number,
            'topic'         => $ticket->topic,
            'question'      => $ticket->question,
            'token'         => $ticket->token,
            'shop_domain'   => $ticket->shop_domain,
            'created_at'    => $response->created_at->format('H:ia d M, Y')
        ];

        \Mail::to("info@monsterlab.com")->send(new \App\Mail\TicketCustomerReply($data));

        return response()->json($ticket);
    }

    public function ticketClose(Request $request, $token)
    {
        $response = $this->ticketRepository->ticketChangeStatus($request, $token);

        return response()->json($response);
    }
}
