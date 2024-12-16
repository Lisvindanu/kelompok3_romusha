<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
       
        <!-- Account Wrapper -->
         <div class="container grid grid-cols-12 items-start gap-6 pt-4 pb-16 mt-7">
            <div class="col-span-3">
                <!-- Account Profile -->
                <div class="px-4 py-3 shadow flex items-center gap-4">
                    <div class="flex-shrinx-0">
                        <img src="" class="rounded-full w-14 h-14 border bg-yellow-500 p-1 object-cover">
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-600">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                 <!-- Profile Links -->
                 <div class="mt-4 bg-yellow-500 shadow rounded p-3 divide-y divide-gray-200 space-y-4 text-black  w-3/5">
                    <div class="space-y-1 pl-5">
                        <a href="" class="relative block font-pixelpy capitalize text-black font-bold">
                            <span class="absolute -left-8 top-0 text-base"><i class="far fa-adress-card"></i></span>
                            Manage Account
                        </a>
                        <a href="" class="relative hover:text-red-500 block font-bold capitalize">
                            Profile Info
                        </a>           
                        <a href="" class="relative hover:text-red-500 font-bold capitalize">
                            Manage address
                        </a>           
                        <a href="" class="relative hover:text-red-500 block font-bold capitalize">
                            Change Password
                        </a>           
                    </div>
                </div>
            </div>
         </div>
    </div>
</x-layout>
