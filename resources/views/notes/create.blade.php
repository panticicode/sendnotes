<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 space-y-4 lg:px-8">
            <x-button icon="arrow-left" class="mb-8" href="{{route('notes.index')}}">All Notes</x-button>
            <livewire:notes.create-note />
        </div>
    </div>
</x-app-layout>
