<div class="">
    <div class="p-8">
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
</div>
<script>
    // function calculateTotalHours() {
    //     const startTime = document.getElementById('start_time').value;
    //     const endTime = document.getElementById('end_time').value;

    //     if (startTime && endTime) {
    //         const start = new Date(`1970-01-01T${startTime}:00`);
    //         const end = new Date(`1970-01-01T${endTime}:00`);

    //         let diffInMinutes = (end - start) / 1000 / 60; // Difference in minutes
    //         if (diffInMinutes < 0) {
    //             // If the end time is before the start time, assume it's the next day
    //             diffInMinutes += 24 * 60;
    //         }

    //         const totalHours = (diffInMinutes / 60).toFixed(2); // Convert to hours and round to 2 decimal places
    //         document.getElementById('total_hours').value = totalHours;

    //         // Trigger Livewire update to set total_hours
    //         //@this.set('timeLogFields.total_hours', totalHours);
    //     }
    // }
</script>    