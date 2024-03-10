<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $body;
    public $recipient;
    public $sendDate;

    public function submit()
    {
        $user = auth()->user();

        $validate = $this->validate([
            'title' => ['required', 'string', 'min:5'],
            'body' => ['required', 'string', 'min:20'],
            'recipient' => ['required', 'email'],
            'sendDate' => ['required', 'date']
        ]);
        $user->notes()->create([
            'title' => $this->title,
            'body' => $this->body,
            'recipient' => $this->recipient,
            'send_date' => $this->sendDate,
            'is_published' => false
        ]);
        redirect()->route('notes.index');
    }
}; ?>

<div>
    <form wire:submit="submit" class="space-y-4">
        <x-input wire:model="title" label="Note Title" placeholder="It's been a great day" />
        <x-textarea wire:model="body" label="Your Note" placeholder="Share all your thoughts with your friend" />
        <x-input icon="user" wire:model="recipient" label="Recipient" type="email" placeholder="Yourfriendemail@.com" />
        <x-input icon="calendar" wire:model="sendDate" type="date" label="Send Date" />
        <div class="pt-4">
            <x-button wire:click="submit" primary right-icon="calendar" spinner>Schedule Note</x-button>
        </div>
        <x-errors />
    </form>
</div>
