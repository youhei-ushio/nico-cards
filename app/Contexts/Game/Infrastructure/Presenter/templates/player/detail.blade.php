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
        {{ $view->self->room->name }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-48 p-6 bg-white border-b border-gray-200">
                    メンバー
                    @foreach ($view->self->room->members as $member)
                        <div>{{ $member->name }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-slot name="member_name">
        {{ $view->self->name }}
    </x-slot>
</x-app-layout>
