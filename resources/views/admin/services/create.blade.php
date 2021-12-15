<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{route('services')}}"
                       class="border w-40 border-teal-500 text-teal-500 block rounded-sm font-bold py-2 px-3 mr-2 flex items-center hover:bg-black-500 hover:text-gray-500">
                        <svg class="h-5 w-5 mr-2 fill-current" version="1.1" id="Layer_1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="-49 141 512 512" style="enable-background:new -49 141 512 512;"
                             xml:space="preserve">
            <path id="XMLID_10_"
                  d="M438,372H36.355l72.822-72.822c9.763-9.763,9.763-25.592,0-35.355c-9.763-9.764-25.593-9.762-35.355,0 l-115.5,115.5C-46.366,384.01-49,390.369-49,397s2.634,12.989,7.322,17.678l115.5,115.5c9.763,9.762,25.593,9.763,35.355,0 c9.763-9.763,9.763-25.592,0-35.355L36.355,422H438c13.808,0,25-11.193,25-25S451.808,372,438,372z"></path>
        </svg>
                        @lang('common.previous_page')
                    </a>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    @if(Session::has('message'))
                                        @php $message = Session::get('message') @endphp
                                    @endif

                                    @if(isset($message))
                                        <div
                                            class="bg-{{$message['color']}}-100 border border-{{$message['color']}}-400 text-{{$message['color']}}-700 px-4 py-3 rounded relative"
                                            role="alert" style="margin-bottom: 30px">
                                            <strong class="font-bold">{{$message['title']}}</strong>
                                            <span class="block sm:inline">{{$message['content']}}</span>
                                        </div>
                                    @endif
                                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                                    <form action="{{route('service.store')}}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex w-full mobile-companent">
                                            <div class="w-1/2 mr-3 mobile-input">
                                                <x-label for="title" :value="__('common.title')"/>

                                                <x-input id="title" maxlength="35" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         :value="old('title')" name="title" required autofocus/>
                                            </div>
                                            <div class="w-1/2 mobile-input">
                                                <x-label for="status" :value="__('common.status')"/>

                                                <select name="rating" class="w-1/2 rounded border-gray-300">
                                                    <option value="Active">Active</option>
                                                    <option value="Upcoming">Upcoming</option>
                                                    <option value="Ended">Ended</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="flex w-full mobile-companent">
                                            <div class="w-1/2 mr-3 mt-4 mobile-input">
                                                <div class="flex w-full">
                                                    <div class="w-1/2 mr-2">
                                                        <x-label for="date_from" :value="__('common.date_from')"/>

                                                        <x-input id="date_from" maxlength="255"
                                                                 class="block mt-1 w-full inputs sm:text-sm"
                                                                 type="date" name="date_from" :value="old('date_from')"
                                                                  autofocus/>
                                                    </div>
                                                    <div class="w-1/2">
                                                        <x-label for="date_to" :value="__('common.date_to')"/>

                                                        <x-input id="date_to" maxlength="255"
                                                                 class="block mt-1 w-full inputs sm:text-sm"
                                                                 type="date" name="date_to" :value="old('date_to')"

                                                                 autofocus/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-1/2 mt-4 customer_number mobile-input">
                                                <label for="role_id"
                                                       class="block text-sm font-medium text-gray-700">@lang('common.type')</label>
                                                <select id="role_id" name="types[]" autocomplete="type_id" multiple
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    @foreach($types as $type)
                                                        <option value="{{$type->id}}">{{$type->title}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent">
                                            <div class="w-full mr-3 mt-4 mobile-input">
                                                <x-label for="date_to" :value="__('common.description')"/>
                                                <textarea name="text" class="border border-gray-300 w-full"
                                                          style="min-height: 300px"></textarea>
                                            </div>
                                        </div>

                                        <div class="flex w-full mobile-companent my-10">
                                            <div class="w-1/4 mr-3 mt-4 mobile-input">
                                                <x-label for="title" :value="__('common.rating')"/>
                                                <select name="rating" class="rounded border-gray-300 w-full">
                                                    <option value="not_rated">@lang('common.rating')</option>
                                                    <option value="promising">@lang('common.promising')</option>
                                                    <option value="high">@lang('common.high')</option>
                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3 mt-4 mobile-input">
                                                <x-label for="title" :value="__('common.rewards')"/>
                                                <x-input id="title" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         placeholder="Rewards"
                                                         :value="old('rewards')" name="rewards" required autofocus/>
                                            </div>
                                            <div class="w-1/4 mr-3 mt-4 mobile-input">
                                                <x-label for="title" :value="__('common.complexity')"/>
                                                <select name="complexity" class="w-full rounded border-gray-300">
                                                    @for($x = 0; $x<20; $x++)
                                                        <option value="{{$x}}">{{$x}}</option>
                                                    @endfor

                                                </select>
                                            </div>
                                            <div class="w-1/4 mr-3 mt-4 mobile-input">
                                                <x-label for="title" :value="__('common.lock')"/>
                                                <x-input id="title" maxlength="255" minlength="1"
                                                         class="block mt-1 w-full inputs sm:text-sm" type="text"
                                                         placeholder="Lock"
                                                         :value="old('lock')" name="lock" required autofocus/>
                                            </div>

                                        </div>

                                        <div class="col-span-12 sm:col-span-12 lg:col-span-12 mt-70">
                                            <label for="image"
                                                   class="block text-sm font-medium text-gray-700">@lang('common.logo')</label>
                                            <input type="file" accept="image/x-png,image/gif,image/jpeg"
                                                   name="logo" id="image"
                                                   class="mt-1 focus:ring-indigo-500 inputs focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="flex items-center justify-end mt-4">
                                            <p><small></small></p>
                                            <x-button class="ml-3">
                                                <i class="fas fa-plus"></i> {{ __('common.create') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
