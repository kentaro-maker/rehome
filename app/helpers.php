<?php

use Illuminate\Support\Facades\Storage;

function logoImage()
{
    return Storage::url('images/logo.svg');
}


function cityImage($slug)
{
    return Storage::url('images/cities/'.$slug.".jpg");
}

 ?>
