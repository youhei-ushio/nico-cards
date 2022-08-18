<?php

declare(strict_types=1);

use App\Contexts\MyPage\Infrastructure\Presenter\ProfileEditView;
use Illuminate\Support\ViewErrorBag;

/**
 * @var ProfileEditView $view
 * @var ViewErrorBag $errors
 */
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('my_page.profile.edit.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-4 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{ route('my_page.profile.update') }}">
                        @csrf
                        <div class="relative z-0 mb-6 w-full group">
                            <input type="text" name="member_name" id="member_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required value="{{ $view->member->name }}" />
                            <label for="member_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('my_page.profile.edit.fields.member_name') }}</label>
                            @error('member_name', $bag ?? null)
                                <span class="text-red-700">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('my_page.profile.edit.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="member_name">
        {{ $view->member->name }}
    </x-slot>
</x-app-layout>
