<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reuniões</h5>
                        <div class="row">
                            <div class="col-md-12">
                                @livewire('reuniao-management')                            
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
