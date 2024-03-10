<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($id)
    {
        $note = Note::find($id);
        //Policies
        $this->authorize('delete', $note);
        $note->delete();
    }
    public function with() : array
    {
        $user = Auth::user();
        return [
            'notes' => $user
                            ->notes()
                            ->orderBy('send_date', 'asc')
                            ->get(),
        ];
    }
}; ?>

<div>
    <div class="space-y-2">
        @if($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No Notes yet!</p>
                <p class="text-sm">let's create your first note to send.</p>
                <x-button primary icon-right="plus" class="mt-6" href="{{route('notes.create')}}" wire:navigate>Create note</x-button>
            </div>
        @else
            <x-button primary icon-right="plus" href="{{route('notes.create')}}" wire:navigate>Create note</x-button>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($notes as $note)
                   <x-card wire:key='{{$note->id}}'>
                        <div class="flex justify-between">
                            <div>
                                <a href="{{route('notes.edit', $note)}}" class="text-xl font-bold hover:underline hover:text-blue-500" wire:navigate>
                                    {{$note->title}}
                                </a>
                                <p class="mt-2 text-xs">{{ Str::limit($note->body, 10) }}</p>
                            </div>
                            <div class="text-xs text-grey-500">
                                {{ $note->send_date->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-xs">Recipient:
                                <span class="font-semibold">{{$note->recipient}}</span>
                            </p>
                            <div>
                                <x-button.circle icon="eye"></x-button>
                                <x-button.circle icon="trash" wire:click="delete('{{$note->id}}')"></x-button>
                            </div>
                        </div>
                   </x-card>
                @endforeach
            </div> 
        @endif   
    </div>
</div>
