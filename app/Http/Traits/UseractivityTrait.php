<?php
namespace App\Http\Traits;
use App\Models\UserExtendedLog;
trait Useractivitytrait {
    public function hasUseractivity($user,$module,$timemsg,$today,$input)
	{
        /**
        * Checks if logged In user has permission to access a particular function.
        *
        * @param  string $permission The Permission slug/key
        * @return Boolean
        */
		$user = auth()->user();
        // dd($input);
        if(is_array($input))
        {
        $data=json_encode($input);
        }
        else
        {
        $data=$input;
        }
        // dd($data);
        $array=[
        'user_id' => $user['id'],
        'customer_id' => $user['role_id'],
        'module' => $module,
        'action_by' => $user['name'],
        'action_name' => $timemsg,
        'acrtion_for_name' => $user['name'],
        'timeline_message' => $timemsg,
        'user_commant'     => $data,
        'next_contactable_date' => $today,
        'action_done_by_name' => $user['name']
        ];
        $data=UserExtendedLog::create($array);

    }
}
