<?php

declare(strict_types=1);

use App\Contexts\Lobby\Infrastructure\Presenter\RoomIndexView;
use Illuminate\Support\ViewErrorBag;

/**
 * @var RoomIndexView $view
 * @var ViewErrorBag $errors
 */
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('lobby.room.index.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-8 space-x-1 lg:grid-cols-3">
                        @foreach ($view->rooms as $room)
                            <a href="{{ $room->exists($view->member) ? route('lobby.rooms.leave', $room->id) : route('lobby.rooms.enter', $room->id) }}" class="flex flex-col items-center bg-white rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <img src="{{ asset('/images/game_tramp_card_man.png') }}" alt="game_tramp_card_man" class="object-cover w-full h-96 rounded-t-lg md:h-auto md:w-48 md:rounded-none md:rounded-l-lg">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h3 class="text-2xl text-center text-gray-800">{{ $room->name }}</h3>
                                    <p class="text-center text-gray-500">{{ __('lobby.room.index.member_count', ['count' => count($room->members)]) }}</p>
                                    <p class="text-center text-lg">
                                        @if ($room->exists($view->member))
                                            {{ __('lobby.room.index.leave') }}
                                        @else
                                            @if ($room->isFull)
                                                {{ __('lobby.room.index.full') }}
                                            @else
                                                {{ __('lobby.room.index.enter') }}
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

    @if (!$view->messages->empty())
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-8 space-x-1 lg:grid-cols-3">
                        <ul class="space-y-1 max-w-md list-disc list-inside text-gray-500 dark:text-gray-400">
                            @foreach($view->messages as $message)
                                <li class="flex items-center">
                                    @if ($message->level->isError())
                                        <svg class="w-4 h-4 mr-1.5 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    @else
                                        <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    @endif
                                    [{{ $message->occurredAt->getValue()->format('H:i:s') }}]
                                    {{ $message->body }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="member_name">
        {{ $view->member->name }}
    </x-slot>
</x-app-layout>
