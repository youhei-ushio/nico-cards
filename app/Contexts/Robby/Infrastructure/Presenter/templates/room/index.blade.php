<?php

declare(strict_types=1);

use App\Contexts\Robby\Infrastructure\Presenter\RoomIndexView;
use Illuminate\Support\ViewErrorBag;

/**
 * @var RoomIndexView $view
 * @var ViewErrorBag $errors
 */
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('robby.room.index.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-8 space-x-1 lg:grid-cols-3">
                        @foreach ($view->rooms as $room)
                            <a href="{{ $room->exists($view->member) ? route('robby.rooms.leave') : route('robby.rooms.enter', $room->id) }}" class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <img src="{{ asset('/images/game_tramp_card_man.png') }}" width="128" height="138" alt="game_tramp_card_man" class="object-cover w-full h-96 rounded-t-lg md:h-auto md:w-48 md:rounded-none md:rounded-l-lg">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h3 class="text-2xl text-center text-gray-800">{{ $room->name }}</h3>
                                    <p class="text-center text-gray-500">{{ __('robby.room.index.member_count', ['count' => count($room->members)]) }}</p>
                                    <p class="text-center text-lg">
                                        @if ($room->exists($view->member))
                                            {{ __('robby.room.index.leave') }}
                                        @else
                                            @if ($room->canEnter)
                                                {{ __('robby.room.index.enter') }}
                                            @else
                                                {{ __('robby.room.index.full') }}
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="member_name">
        {{ $view->member->name }}
    </x-slot>
</x-app-layout>
