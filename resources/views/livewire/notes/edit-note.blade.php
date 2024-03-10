<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $title;
    public $body;
    public $recipient;
    public $sendDate;
    public $noteIsPublished;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->title = $note->title;
        $this->body = $note->body;
        $this->recipient = $note->recipient;
        $this->sendDate = $note->send_date->format('Y-m-d');
        $this->noteIsPublished = $note->is_published;
    }
    public function save()
    {
        $validate = $this->validate([
            'title' => ['required', 'string', 'min:5'],
            'body' => ['required', 'string', 'min:20'],
            'recipient' => ['required', 'email'],
            'sendDate' => ['required', 'date']
        ]);

        $this->note->update([
            'title' => $this->title,
            'body' => $this->body,
            'recipient' => $this->recipient,
            'send_date' => $this->sendDate,
            'is_published' => $this->noteIsPublished
        ]);
        $this->dispatch('note-saved');
    }
}; ?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-500">
        {{ __('Edit Note') }}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
        <form wire:submit="save" class="space-y-4">
            <x-input wire:model="title" label="Note Title" placeholder="It's been a great day" />
            <x-textarea wire:model="body" label="Your Note" placeholder="Share all your thoughts with your friend" />
            <x-input icon="user" wire:model="recipient" label="Recipient" type="email" placeholder="Yourfriendemail@.com" />
            <x-input icon="calendar" wire:model="sendDate" type="date" label="Send Date" />
            <x-checkbox label="Note Published" wire:model="noteIsPublished" />
            <div class="pt-4">
                <x-button type="submit" primary spinner="save">Save Note</x-button>
                <x-button href="{{route('notes.index')}}" flat negative>Back to Notes</x-button>
            </div>
            <x-action-message on="note-saved" />
            <x-errors />
        </form>
    </div>
</div>

