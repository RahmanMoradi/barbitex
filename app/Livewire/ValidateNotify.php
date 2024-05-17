<?php


namespace App\Livewire;


use Illuminate\Support\Facades\Validator;

trait ValidateNotify
{
    public function validateNotify($data,$rules)
    {
        $validator = Validator::make($data,$rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                flash($error)->error()->livewire($this);
            }
            return;
        }
    }
}
