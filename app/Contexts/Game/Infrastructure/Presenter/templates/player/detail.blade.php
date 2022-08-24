<?php

declare(strict_types=1);

use App\Contexts\Game\Infrastructure\Presenter\PlayerDetailView;
use Illuminate\Support\ViewErrorBag;

/**
 * @var PlayerDetailView $view
 * @var ViewErrorBag $errors
 */
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('game.round.title') }}
        </h2>
        {{ $view->room->name }}
    </x-slot>

    @if ($view->round === null)
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <div class="grid gap-8 space-x-1 lg:grid-cols-4">
                            @foreach ($view->room->members as $member)
                                <div class="flex flex-col items-center bg-white rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
                                    <img src="{{ $view->getPlayerImagePath($member->id) }}" alt="player" class="object-cover h-20 rounded-t-lg md:rounded-none md:rounded-l-lg">
                                    <h4 class="text-2xl">{{ $member->name }}</h4>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 ">
                            <a href="{{ route('game.round.start') }}" class="mt-6 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                {{ __('game.room.start') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid gap-8 space-x-1 lg:grid-cols-3">
                            @foreach ($view->round->opponents as $opponent)
                                <div class="flex flex-col items-center {{ $opponent->onTurn ? 'bg-yellow-200' : 'bg-white' }} rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
                                    <img src="{{ $view->getPlayerImagePath($opponent->id) }}" alt="player" class="object-cover h-20 rounded-t-lg md:rounded-none md:rounded-l-lg">
                                    <h4 class="text-2xl">{{ $opponent->name }}</h4>
                                    <img src="{{ asset('images/card_back.png') }}" alt="card" class="object-cover h-16 rounded-t-lg md:rounded-none md:rounded-l-lg ml-12 mr-2">
                                    {!! __('game.round.number_of_hands', ['count' => $opponent->hand]) !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid gap-8 space-x-1 lg:grid-cols-4">
                            <div class="flex flex-col items-center justify-center bg-white rounded-lg border border-gray-400 shadow-md md:flex-row dark:border-gray-700 dark:bg-gray-800 h-56">
                                {!! __('game.round.turn', ['turn' => $view->round->turn->getValue()]) !!}
                            </div>
                            <div class="board p-6 flex-col col-span-2 items-center bg-green-600 rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800 h-56 pl-20" data-room_id="{{ $view->room->id }}">
                                <div class="upcard h-full">
                                    @foreach($view->round->upcards as $card)
                                        <img src="{{ $view->getCardImagePath($card) }}" alt="upcard" class="card object-cover h-48 rounded-t-lg md:rounded-none md:rounded-l-lg" data-suit="{{ $card->suit }}" data-number="{{ $card->number }}">
                                    @endforeach
                                </div>
                                <div class="play" data-member_id="{{ $view->member->id }}">

                                </div>
                            </div>
                            <div class="flex flex-col items-center justify-center bg-white rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800 h-56 {{ $view->round->player->onTurn ? 'bg-yellow-200' : 'bg-white' }}">
                                <div class="mt-6">
                                    <img src="{{ $view->getPlayerImagePath($view->member->id) }}" alt="player" class="object-cover h-20 rounded-t-lg md:rounded-none md:rounded-l-lg">
                                    <h4 class="text-2xl">{{ $view->member->name }}</h4>
                                    @if ($view->round->player->onTurn)
                                        <button id="play_button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mt-2">
                                            {{ __('game.round.play') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="my-hand p-6 bg-white border-b border-gray-200 pl-20">
                        @foreach($view->round->player->hand as $card)
                            <img src="{{ $view->getCardImagePath($card) }}" alt="hand" class="hand card {{ $view->round->player->onTurn ? 'playable' : '' }} object-cover h-48 rounded-t-lg md:rounded-none md:rounded-l-lg cursor-pointer" data-suit="{{ $card->suit }}" data-number="{{ $card->number }}">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="member_name">
        {{ $view->member->name }}
    </x-slot>
</x-app-layout>
