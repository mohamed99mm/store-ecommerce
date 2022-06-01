<?php


define('PaginationCount',15);


 function getFolder()
{
return app()->getLocale() === 'ar'? 'css-rtl':'css';
}

function uploadImage($folder,$image)
{
    $image->store('/',$folder) ;
    $filename = $image->hashname();
    return $filename;
}


