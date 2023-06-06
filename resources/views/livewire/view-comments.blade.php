<div wire:poll.5s>
    <ul role="list" class="space-y-6">
        @forelse ($comments as $comment)
        <li class="relative flex gap-x-4">
            <div class="absolute left-0 top-0 flex w-6 justify-center -bottom-6">
                <div class="w-px bg-gray-200"></div>
            </div>
            {{-- @if ($comment->user->personal_information->photo != null )
            <img src="{{Storage::url($comment->user->personal_information->photo)}}" alt="" class="relative mt-3 h-7 w-7 flex-none rounded-full bg-gray-50">
            @else --}}
            <img src="{{asset('images/sksu1.png')}}" alt="" class="relative mt-3 h-7 w-7 flex-none rounded-full bg-gray-50">

            {{-- @endif --}}

            <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                <div class="flex justify-between gap-x-4">
                <div class="py-0.5 text-sm leading-5 text-gray-500"><span class="font-medium text-gray-900">{{$comment->user->name}}</span> <span class="text-xs"></span> </div>
                <time datetime="2023-01-23T15:56" class="flex-none py-0.5 text-2xs leading-5 text-gray-500">{{$comment->created_at->diffForHumans()}}</time>
                </div>
                <p class="text-sm leading-6 text-gray-500 break-words pr-5">{{$comment->comment}}</p>
            </div>
            </li>
        @empty
        <div class="font-md font-semibold italic flex justify-center bg-gray-200 py-2 rounded-sm">
           - NO COMMENTS YET -
        </div>
        @endforelse
    </ul>
</div>
