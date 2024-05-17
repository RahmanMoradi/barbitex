<?php

namespace App\Livewire\Admin\User;

use App\Models\Card\Card;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithPagination;

class Cards extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    /**
     * @var mixed|null
     */
    public $user_id, $filter = null;

    protected $queryString = ['filter'];

    public function mount($user_id = null)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        $cards = $this->getCards();
        return view('livewire.admin.user.cards', compact('cards'));
    }

    public function changeStatus($status, $id)
    {
        $card = Card::find($id);
        $card->update([
            'status' => $status
        ]);

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function delete($id)
    {
        $card = Card::find($id);
        $card->delete();
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function getCards()
    {
        $cards = Card::query();
        if ($this->user_id) {
            $cards = $cards->where('user_id', $this->user_id);
        }
        if ($this->filter != null) {
            $cards = $cards->where('status', $this->filter);
        }
        return $cards->orderByDesc('created_at')->paginate();
    }

    public function inquiryIban($iban)
    {
        $response = \Inquiry::cardInfo([
            'value' => $iban,
        ]);
        if ($response['code'] === 200) {
            $this->dispatchBrowserEvent('callbackInquiry', ['response' => $response, 'type' => 'iban']);
        } else {
            flash(__('نتیجه نامشخص!'), 'error')->livewire($this);
        }
    }

    public function inquiryCard($card)
    {
        $response = \Inquiry::cardInfo([
            'cardNumber' => $card
        ]);
        if ($response['code'] === 200) {
            $this->dispatchBrowserEvent('callbackInquiry', ['response' => $response, 'type' => 'card']);
        } else {
            flash(__('نتیجه نامشخص!'), 'error')->livewire($this);
        }
    }

    public function matchingCardWithNational(Card $card)
    {
        if (!$card->card_number || !$card->user->national_code || !$card->user->birthday) {
            flash('اطلاعات وارد شده کامل نیست!', 'error')->livewire($this);
            return;
        }
        $response = \Inquiry::matchingCardWithNational([
            'cardNumber' => $card->card_number,
            'nationalCode' => $card->user->national_code,
            'birthday' => $card->user->birthday,
        ]);
        if ($response['code'] === 200) {
            if ($response['matched']) {
                flash(__('اطلاعات با کد ملی مطابقت دارد'), 'success')->livewire($this);
            } else {
                flash(__('اطلاعات با کد ملی مطابقت ندارد'), 'error')->livewire($this);
            }
        } else {
            flash(__('نتیجه نامشخص!'), 'error')->livewire($this);
        }
    }
}
