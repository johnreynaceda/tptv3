@props(['title', 'count', 'class' => '']) <!-- Accept an optional 'class' prop -->

<li {{ $attributes->merge(['class' => 'col-span-1 p-3 divide-y divide-gray-200 ' . $class]) }}> <!-- Merge default and passed classes -->
    <div class="grid">
        <div class="flex">
            <div class="p-2 text-white bg-gray-400 rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <div class="mt-2">
            <h1>
                {{ $title }}
            </h1>
        </div>
        <div class="mt-1">
            <h1 class="text-xl">{{ $count }}</h1>
        </div>
    </div>
</li>
