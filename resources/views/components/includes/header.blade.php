@props([
    'header' => $header,
])
<div class="w-full mb-2">  
  <header class="bg-white dark:bg-gray-800 shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{$header}}</h1>
    </div>
  </header>
</div>