<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\User\UserDocument;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class Documents extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $newDocuments = UserDocument::whereStatus('new')->orderByDesc('created_at')->paginate();
        $acceptDocuments = UserDocument::whereStatus('accept')->orderByDesc('created_at')->paginate();
        $failedDocuments = UserDocument::whereStatus('failed')->orderByDesc('created_at')->paginate();
        return view('livewire.admin.user.documents', compact('newDocuments', 'acceptDocuments', 'failedDocuments'));
    }

    public function update(UserDocument $doc, $status)
    {

        $user = User::find($doc->user_id);
        if ($status == 'accept') {
            $user->markDocAsVerified();
        } elseif ($status == 'failed') {
            $user->markDocAsFailed();
        } else {
            $user->update([
                'doc_verified_at' => null,
            ]);
        }
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->render();
    }
}
