<?php

namespace App\Models\Traits\User;

use Illuminate\Auth\Notifications\VerifyEmail;

trait MustVerifyDoc
{
    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedDoc()
    {
        return !is_null($this->doc_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markDocAsVerified()
    {
        $this->docs->update([
            'status' => 'accept'
        ]);
        return $this->forceFill([
            'doc_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markDocAsFailed()
    {
        $this->docs->update([
            'status' => 'failed'
        ]);
        return $this->update([
            'doc_verified_at' => null,
        ]);
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getDocForVerification()
    {
        return optional($this->doc)->image;
    }
}
