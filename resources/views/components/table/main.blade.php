<div>
    <div class="pt-2 bg-white border border-gray-300 rounded-lg">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center ">
                <div class=" sm:flex-auto">
                    {{ $leftAction ?? '' }}
                </div>
                <div class="flex mt-4 space-x-3 sm:mt-0 sm:ml-16 sm:flex-none">
                    {{ $rightAction ?? '' }}
                </div>
            </div>
            <div class="flex flex-col mt-2">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="overflow-hidden rounded-b-lg shadow-sm ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        {{ $heading ?? '' }}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{ $body ?? '' }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3">
        {{ $footer ?? '' }}
    </div>
</div>
