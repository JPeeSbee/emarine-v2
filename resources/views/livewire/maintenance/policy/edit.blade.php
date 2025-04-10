<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <!-- content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <!-- header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Edit {{$title}}
                </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-hide="default-modal">
                <flux:navlist.item icon="arrow-left" :href="route('maintenance.policy')" wire:navigate/>
            </button>
        </div>
        <!-- Modal body -->
        <form class="max-w-xs md:max-w-lg mx-auto my-12" wire:submit='update'>
            {{-- <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" />
                <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Password</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="repeat_password" id="repeat_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" />
                <label for="repeat_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Confirm password</label>
            </div> --}}
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model='policy_number' type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $policy->policy_number) }}" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="" />
                    <label for="policy_number" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                        {{$title}} Number
                    </label>
                    @error('policy_number')
                        <em class="text-red-300 text-xs">{{ $message }}</em>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model='agent_id' name="agent_id" id="underline_select" class="block w-full py-2.5 px-2 text-sm text-gray-900 border-0 border-b-2 border-gray-300 bg-transparent focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Select Agent</option>
                        @foreach ($agents as $agent)
                            <option value="{{$agent->id}}" class="text-black dark:text-white">{{$agent->name}}</option>
                        @endforeach
                    </select>
                    @error('agent_id')
                        <em class="text-red-300 text-xs">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>
    </div>
</div>