<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div style="padding-bottom: 10px; font-size: 24px;">
                        <h3>Active Companies </h3>
                    </div>
                    <ol>
                        @foreach($companies as $company)
                            <li>
                            {{ ++$loop->index }} . {{ $company->name }}
                                <div style="padding-left: 30px;padding-bottom: 10px;">
                                    <ol>
                                        @foreach($company->products as $product)
                                            <li> {{ ++$loop->index }} . {{ $product->name }} {{ !$product->status ? ' (inactive)' : '' }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
