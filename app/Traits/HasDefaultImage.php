<?php

namespace App\Traits;

trait HasDefaultImage {
    public function getImage($altName, $image) {
        if(!$image) {
            return "https://ui-avatars.com/api/?name=$altName&size=150";
        }
        return $image;
    }
}