<?php
public $follower = 'follow';
    public $password;
    public function toggle_follow()
    {
        $followship = Follower::where('user_id', Auth::user()->id)->where('target_id', $this->user->id)->first();
        if ($followship) {
            $followship->delete();
            $this->follower = 'follow';
        } else {
            Follower::create([
                'user_id' => Auth::user()->id,
                'target_id' => $this->user->id
            ]);
            $this->follower = 'Following';
        }
    }