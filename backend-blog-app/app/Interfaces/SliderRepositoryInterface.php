<?php

namespace App\Interfaces;

interface SliderRepositoryInterface
{
    public function getAllSlider();
    public function deleteSlider($id);
    public function createSlider($request);
    public function updateSlider($id, $request);
    public function getSliderById($id);
}
