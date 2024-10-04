<div>
<h2 class="text-xl font-bold mb-4">Log Your Time</h2>

@if (session()->has('message'))
    <div class="p-4 mb-4 bg-green-200 text-green-700">
        {{ session('message') }}
    </div>
@endif

<form wire:submit.prevent="save">
    {{ $this->form }}

    <div class="mt-4">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
            Save Time Log
        </button>
    </div>
</form>
</div>
