<!-- drawer init and show -->
 
 <!-- drawer component -->
 <div id="drawer-navigation" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-64 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
   <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
   <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
     <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
     </svg>
     <span class="sr-only">Close menu</span>
  </button>
 <div class="py-4 overflow-y-auto">
     <ul class="space-y-2 font-medium">
        <li>
           <a wire:navigate href="/" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->is('/')) bg-gray-200 dark:bg-gray-700 @else hover:bg-gray-100 dark:hover:bg-gray-700 @endif group">
              <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                 <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                 <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
              </svg>
              <span class="ms-3">Todos</span>
           </a>
        </li>
        <li>
             <a wire:navigate href="/counter" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->is('counter')) bg-gray-200 dark:bg-gray-700 @else hover:bg-gray-100 dark:hover:bg-gray-700 @endif group">
                <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                   <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                </svg>
                <span class="flex-1 ms-3 whitespace-nowrap">Counter</span>
             </a>
         </li>
         <li>
            <a wire:navigate href="posts" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white @if(request()->is('posts')) bg-gray-200 dark:bg-gray-700 @else hover:bg-gray-100 dark:hover:bg-gray-700 @endif group">
               <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">posts</span>
               <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
            </a>
         </li>
     </ul>
  </div>
</div>

<script>
 function initializeDrawerNavigation() {
   const drawerToggleButtons = document.querySelectorAll("[data-drawer-target]");
   const drawerNavigation = document.getElementById("drawer-navigation");
   const closeMenuButton = document.querySelector("[data-drawer-hide]");
   
   // Remove existing event listeners
   drawerToggleButtons.forEach(button => {
     const newButton = button.cloneNode(true);
     button.parentNode.replaceChild(newButton, button);
   });

   if (closeMenuButton) {
     const newCloseButton = closeMenuButton.cloneNode(true);
     closeMenuButton.parentNode.replaceChild(newCloseButton, closeMenuButton);
   }

   const collapseToggleButtons = document.querySelectorAll("[data-collapse-toggle]");
   collapseToggleButtons.forEach(button => {
     const newButton = button.cloneNode(true);
     button.parentNode.replaceChild(newButton, button);
   });

   // Re-attach event listeners
   document.querySelectorAll("[data-drawer-target]").forEach(button => {
     button.addEventListener("click", () => {
       if (drawerNavigation.classList.contains("-translate-x-full")) {
         drawerNavigation.classList.remove("-translate-x-full");
       } else {
         drawerNavigation.classList.add("-translate-x-full");
       }
     });
   });

   document.querySelector("[data-drawer-hide]")?.addEventListener("click", () => {
     drawerNavigation.classList.add("-translate-x-full");
   });

   document.querySelectorAll("[data-collapse-toggle]").forEach(button => {
     button.addEventListener("click", () => {
       const target = document.getElementById(button.getAttribute("aria-controls"));
       if (target.classList.contains("hidden")) {
         target.classList.remove("hidden");
       } else {
         target.classList.add("hidden");
       }
     });
   });
 }

 document.addEventListener("DOMContentLoaded", () => {
   initializeDrawerNavigation();
 });

 document.addEventListener('livewire:load', () => {
   initializeDrawerNavigation();
 });

 document.addEventListener('livewire:update', () => {
   initializeDrawerNavigation();
 });

 document.addEventListener('livewire:navigate', () => {
   initializeDrawerNavigation();
 });

 document.addEventListener('livewire:navigating', () => {
   initializeDrawerNavigation();
 });

 document.addEventListener('livewire:navigated', () => {
   initializeDrawerNavigation();
 });
</script>