<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                @if (session()->has('message'))
                <div class="p-4 mb-4 bg-green-200 text-green-700">
                    {{ session('message') }}
                </div>
                @endif
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Search" required="">
                        </div>
                    </div>

                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                @include('livewire.includes.table-sortable-th',[
                                'name' => 'user_name',
                                'displayName' => 'Name'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                'name' => 'subproject_name',
                                'displayName' => 'SubProject'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                'name' => 'department_name',
                                'displayName' => 'Department'
                                ])

                                <th scope="col" class="px-4 py-3">Date</th>
                                <th scope="col" class="px-4 py-3">Start Time</th>
                                <th scope="col" class="px-4 py-3">End Time</th>
                                <th scope="col" class="px-4 py-3">Total Time</th>

                                @include('livewire.includes.table-sortable-th',[
                                'name' => 'created_at',
                                'displayName' => 'Created'
                                ])
                                <th scope="col" class="px-4 py-3">Last update</th>
                                @role('manager')
                                <th scope="col" class="px-4 py-3">
                                    Actions
                                </th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timelogs as $timelog)
                            <?php // echo dd($timelog); 
                            ?>
                            <tr wire:key="{{ $timelog->id }}" class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $timelog->user->name }}
                                </th>
                                <td class="px-4 py-3">{{ $timelog->subproject->name }}</td>
                                <td class="px-4 py-3 {{ $timelog->is_admin ? 'text-green-500' : 'text-blue-500' }}">
                                    {{ $timelog->subproject->project->department->name }}
                                </td>
                                <td class="px-4 py-3">{{ $timelog->date }}</td>
                                <td class="px-4 py-3">{{ $timelog->start_time }}</td>
                                <td class="px-4 py-3">{{ $timelog->end_time }}</td>
                                <td class="px-4 py-3">{{ $timelog->total_hours }}</td>
                                <td class="px-4 py-3">{{ $timelog->created_at }}</td>
                                <td class="px-4 py-3">{{ $timelog->updated_at }}</td>
                                @role('manager')
                                <td class="px-4 py-3 flex items-center justify-end">
                                    <button wire:click="editTimeLog({{ $timelog->id }})"
                                        class="px-3 py-1 mx-2 bg-green-500 text-white rounded">Edit</button>
                                    <button
                                        wire:click="confirmDelete({{ $timelog->id }})"
                                        class="px-3 py-1 bg-red-500 text-white rounded">X</button>

                                </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                            <select wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $timelogs->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Time Log Modal -->

    @if($editMode)
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-semibold mb-4">Edit Time Log</h2>

            <form wire:submit.prevent="updateTimeLog" class="space-y-4">
                <div class="flex flex-col">
                    <label for="subproject" class="mb-1">Subproject</label>
                    <select wire:model="timeLogFields.subproject_id" class="border border-gray-300 rounded p-2">
                        @foreach($subprojects as $subproject)
                        <option value="{{ $subproject->id }}">{{ $subproject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="user" class="mb-1">User</label>
                    <select wire:model="timeLogFields.user_id" class="border border-gray-300 rounded p-2">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="date" class="mb-1">Date</label>
                    <input type="date" wire:model="timeLogFields.date" class="border border-gray-300 rounded p-2" />
                </div>
                <div class="flex flex-col">
                    <label for="start_time" class="mb-1">Start Time</label>
                    <input type="time" step="1" wire:model="timeLogFields.start_time" class="border border-gray-300 rounded p-2" />
                </div>
                <div class="flex flex-col">
                    <label for="end_time" class="mb-1">End Time</label>
                    <input type="time" step="1" wire:model="timeLogFields.end_time" class="border border-gray-300 rounded p-2" />
                </div>
                <div class="flex flex-col">
                    <label for="total_hours" class="mb-1">Total Time</label>
                    <input type="number" wire:model="timeLogFields.total_hours" class="border border-gray-300 rounded p-2" />
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Save</button>
                    <button type="button" wire:click="$set('editMode', false)" class="bg-red-500 text-white rounded px-4 py-2">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif
    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-xl font-semibold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this item?</p>

            <div class="flex justify-end space-x-4 mt-6">
                <button wire:click="$set('showDeleteModal', false)" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
                <button wire:click="delete" class="bg-red-500 text-white rounded px-4 py-2">Delete</button>
            </div>
        </div>
    </div>
    @endif

</div>