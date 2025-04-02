<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <!-- content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <!-- header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Policy Details
                </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-hide="default-modal">
                <flux:navlist.item icon="arrow-left" :href="route('maintenance.policy')" wire:navigate/>
            </button>
        </div>
        <!-- Modal body -->
        <div class="max-w-xs md:max-w-lg mx-auto my-12">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <label for="policy_number" class="text-sm text-gray-500 dark:text-gray-400">Policy Number</label>
                    <input type="text" name="policy_number" id="policy_number" value="{{$policy->policy_number}}" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="agent_id" class="text-sm text-gray-500 dark:text-gray-400">Agent Name</label>
                    <input type="text" name="agent_id" id="agent_id" value="{{$policy->agent->name}}" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" readonly/>
                </div>
            </div>
        </div>
    </div>
</div>