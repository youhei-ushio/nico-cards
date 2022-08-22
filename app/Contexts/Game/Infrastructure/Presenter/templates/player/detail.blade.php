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
            {{ __('game.player.detail.title') }}
        </h2>
        {{ $view->room->name }}
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-8 space-x-1 lg:grid-cols-3">
                        @foreach ($view->self->opponents as $index => $opponent)
                            <div class="flex flex-col items-center bg-white rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
                                <img src="{{ $view->getPlayerImagePath($index) }}" alt="player" class="object-cover h-20 rounded-t-lg md:rounded-none md:rounded-l-lg">
                                <h4 class="text-2xl">{{ $opponent->name }}</h4>
                                <img src="{{ asset('images/card_back.png') }}" alt="card" class="object-cover h-16 rounded-t-lg md:rounded-none md:rounded-l-lg ml-12 mr-2">
                                {{ __('game.player.detail.number_of_hands', ['count' => 0]) }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-8 space-x-1 lg:grid-cols-2">
                        <div class="flex flex-col items-center bg-green-600 rounded-lg border border-gray-400 shadow-md md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800 h-64">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                </div>
            </div>
        </div>
    </div>

    <x-slot name="member_name">
        {{ $view->self->name }}
    </x-slot>
</x-app-layout>
