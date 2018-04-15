<?php
namespace App\Contracts;

interface MusicSearchInterface
{
    public function search($query);

    public function charts($country);
}