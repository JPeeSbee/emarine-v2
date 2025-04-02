@if(session('info'))
  <div x-data="{ show: true }" x-show="show" class="p-2 mb-2 text-sm text-blue-500 rounded-lg bg-blue-100 dark:bg-blue-900 dark:text-blue-400" role="alert">
    <span class="font-medium">{{ session('info') }}</span>
    <button type="button" @click="show = false" class="float-right ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
  </div>
@elseif(session('error'))
<div x-data="{ show: true }" x-show="show" class="p-2 mb-2 text-sm text-red-500 rounded-lg bg-red-100 dark:bg-red-300 dark:text-red-500" role="alert">
  <span class="font-medium">{{ session('error') }}</span>
  <button type="button" @click="show = false" class="float-right ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-700 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
    <span class="sr-only">Close</span>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
  </button>
</div>
@elseif(session('success'))
  <div x-data="{ show: true }" x-show="show" class="p-2 mb-2 text-sm text-green-500 rounded-lg bg-green-100 dark:bg-green-900 dark:text-green-400" role="alert">
    <span class="font-medium">{{ session('success') }}</span>
    <button type="button" @click="show = false" class="float-right ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
  </div>
@elseif(session('warning'))
  <div x-data="{ show: true }" x-show="show" class="p-2 mb-2 text-sm text-yellow-500 rounded-lg bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-400" role="alert">
    <span class="font-medium">{{ session('warning') }}</span>
    <button type="button" @click="show = false" class="float-right ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
    </button>
  </div>
@endif