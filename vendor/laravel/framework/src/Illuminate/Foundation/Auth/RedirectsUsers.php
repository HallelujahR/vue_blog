<?php

namespace Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\URL;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
       return URL::previous();
    }
}
