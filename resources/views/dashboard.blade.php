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
                    You're logged in! <br><b>Tulpar !</b>
{{--                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                        <div class="p-6 bg-white border-b border-gray-200" id="counter">--}}
{{--                            <div class="dashboard-list">--}}
{{--                                <div class="list-title">Toplam Müşteri </div>--}}
{{--                                <div class="list-content counter-val"><span data-count="4">4</span></div>--}}
{{--                            </div>--}}
{{--                            <div class="dashboard-list">--}}
{{--                                <div class="list-title">Toplam Sipariş </div>--}}
{{--                                <div class="list-content counter-val"><span data-count="3">3</span></div>--}}
{{--                            </div>--}}
{{--                            <div class="dashboard-list">--}}
{{--                                <div class="list-title">Toplam Ürün</div>--}}
{{--                                <div class="list-content counter-val"><span data-count="4">4</span></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
