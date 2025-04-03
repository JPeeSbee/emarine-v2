<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <!-- content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <!-- header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Add Role
                </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-hide="default-modal">
                <flux:navlist.item icon="arrow-left" :href="route('maintenance.user')" wire:navigate/>
            </button>
        </div>
        <!-- Modal body -->
        <form class="max-w-sm md:max-w-lg mx-auto my-12" wire:submit='store'>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 p-2 group"> 
                    <input wire:model='name' type="text" name="name" id="name" value="{{old('name')}}" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=""/>
                    <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                        Role Name
                    </label>
                    @error('name')
                        <em class="text-red-300 text-xs">{{ $message }}</em>
                    @enderror
                </div>
                <div class="relative col-span-2 z-0 w-full mb-5 p-2 group">
                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Technology</h3>
                    <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($role_access as $permission)
                            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                <div class="flex items-center ps-3">
                                    <input id="permission_{{$permission->id}}" type="checkbox" name="selectedPermission[]" value="{{$permission->name}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="permission_{{$permission->id}}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$permission->name}}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    @error('permissions')
                        <em class="text-red-300 text-xs">{{ $message }}</em>
                    @enderror
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </div>
</div>