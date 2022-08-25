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
            @if ($view->hasRound())
                {!! __('game.round.turn', ['turn' => $view->round->turn]) !!}
            @endif
        </h2>
        {{ $view->room->name }}
    </x-slot>

    @if ($view->hasRound())
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
                        <div class="grid gap-8 space-x-1 lg:grid-cols-8">
                            <div class="flex flex-col col-span-3 p-6 bg-white rounded-lg border border-gray-400 shadow-md md:flex-row dark:border-gray-700 dark:bg-gray-800 h-56">
                                @if (!$view->messages->empty())
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
                                @endif
                            </div>
                            <div class="board p-6 flex-col col-span-4 items-center bg-green-600 rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800 h-56 pl-20" data-room_id="{{ $view->room->id }}">
                                <div class="upcard h-full">
                                    @foreach($view->round->upcard ?? [] as $card)
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
                    <div class="my-hand p-6 bg-white border-b border-gray-200 pl-20 ml-auto mr-auto">
                        @foreach($view->round->player->hand as $card)
                            <img src="{{ $view->getCardImagePath($card) }}" alt="hand" class="hand card {{ $view->round->player->onTurn ? 'playable' : '' }} object-cover h-48 rounded-t-lg md:rounded-none md:rounded-l-lg cursor-pointer" data-suit="{{ $card->suit }}" data-number="{{ $card->number }}">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
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
                            <button id="start_button" class="mt-6 w-40 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" data-member_id="{{ $view->member->id }}">
                                {{ __('game.round.start') }}
                            </button>
                            <button id="leave_button" class="w-40 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-member_id="{{ $view->member->id }}">
                                {{ __('game.round.leave') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="member_name">
        {{ $view->member->name }}
    </x-slot>
</x-app-layout>
