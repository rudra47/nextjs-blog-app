<?php

namespace App\Interfaces;

interface OfferRepositoryInterface {
    public function getAllOffer();
    public function getOfferById($id);
    public function deleteOffer($id);
    public function createOffer($request);
    public function updateOffer($id, $request);
}
