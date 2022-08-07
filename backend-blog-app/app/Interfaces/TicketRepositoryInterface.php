<?php

namespace App\Interfaces;

interface TicketRepositoryInterface
{
    public function getAllTicket();
    public function getTicketsByUserId($id);
    public function getTicketById($id);
    public function getTicketByToken($token);
    public function getAllDiscussions($id);
    public function createDiscussion($id, $request);
    public function createDiscussionForUser($id, $request);
    public function createTicket($request);
    public function ticketChangeStatus($request, $token);
}
