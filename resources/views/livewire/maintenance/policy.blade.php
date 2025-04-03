<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <x-includes.header :header="'Policies'"/>
    <x-includes.message />
    <div class="grid auto-rows-min gap-4 ">
        <div class="relative lg:overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @if($createPolicy)
                @include('livewire.maintenance.policy.create')
            @elseif($showPolicy)
                @include('livewire.maintenance.policy.show')
            @elseif($editPolicy)
                @include('livewire.maintenance.policy.edit')
            @else
                <div class="relative grid grid-cols-4 m-2">
                    <form class="block" wire:model.live.debounce.150ms='search'>
                        <input type="text" id="search" class="block rounded-t-lg px-2 py-2 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Search Here.. " />
                    </form>
                    <div class="col-span-2 col-start-3 flex justify-end space-x-2">
                        <button type="button" class="focus:outline-none text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm dark:focus:ring-green-900" title="Create Policy">
                            <flux:navlist.item icon="plus" :href="'#'" wire:click.prevent="create()"/>
                        </button>
                    </div>
                </div>
                <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Policy Number
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Agent Name
                            </th>
                            <th scope="col" class="w-1/18">
                                View
                            </th>
                            <th scope="col" class="w-1/18">
                                Edit
                            </th>
                            <th scope="col" class="w-1/18">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($policies as $key => $policy)
                            <tr wire.key="{{$policy->id}}" class="@if($key%2==0) bg-gray-200 dark:bg-gray-600 @else bg-white dark:bg-gray-800 @endif border-b dark:border-gray-700 border-gray-200">
                                <th scope="row" class="p-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$policy->policy_number}}
                                </th>
                                <td class="p-4">
                                    {{$policy->agent->name}}
                                </td>
                                <td>
                                    <button type="button" class="focus:outline-none text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:focus:ring-blue-900" title="View Details">
                                        <flux:navlist.item icon="magnifying-glass" :href="'#'" wire:click.prevent="show({{ $policy->id }})"/>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="focus:outline-none text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm dark:focus:ring-yellow-900" title="Edit Policy">
                                        <flux:navlist.item icon="pencil-square" :href="'#'" wire:click.prevent="edit({{ $policy->id }})"/>
                                    </button>
                                </td>
                                <td>
                                    <button type="button"class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" title="Delete Policy">
                                        <flux:navlist.item icon="trash" :href="'#'" 
                                            wire:click.prevent='deletePolicy({{$policy->id}})'
                                            wire:confirm='are you sure you want to delete this policy?'
                                        />
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-4">
                    {{ $policies->links() }}
                </div>
            @endif
        </div>
    </div>
</div>