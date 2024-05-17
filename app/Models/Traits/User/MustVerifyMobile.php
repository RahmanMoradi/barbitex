<?php

namespace App\Models\Traits\User;

use App\Notifications\User\SendLoginCodeNotification;
use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyMobile
{
    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedMobile()
    {
        return !is_null($this->mobile_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified()
    {
        return $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification()
    {
        $this->notify(new SendLoginCodeNotification('sms'));
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getMobilForVerification()
    {
        return $this->mobile;
    }
}
