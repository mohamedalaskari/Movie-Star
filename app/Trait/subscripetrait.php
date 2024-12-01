<?php

namespace App\Trait;

use App\Models\SubscriptionDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait subscripetrait
{
    public  function Subscripe()
    {
        $user_id = Auth::user()->id;
        $active_subscribtion = SubscriptionDetails::all()->where('user_id', $user_id)->where('expiry_date', '>=', Carbon::now());
        if(count($active_subscribtion) === 0){
            return false;
        }else{
            return true;
        }
    }
}
