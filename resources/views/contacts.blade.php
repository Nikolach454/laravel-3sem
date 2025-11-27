@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="mb-4">
            <h1 class="display-5 fw-bold">Контакты</h1>
            <p class="lead text-muted">Свяжитесь с нами любым удобным способом</p>
            <hr class="my-4">
        </div>


        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-4">Контактная информация</h2>
                        <div class="row g-4">
                            @foreach($contacts as $contact)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        @if($contact['type'] == 'address')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill text-danger" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                        </svg>
                                        @elseif($contact['type'] == 'phone')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-telephone-fill text-success" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                        </svg>
                                        @elseif($contact['type'] == 'email')
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-envelope-fill text-primary" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill text-info" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1">{{ $contact['title'] }}</h5>
                                        <p class="mb-0 text-muted">{{ $contact['value'] }}</p>
                                        @if(isset($contact['description']))
                                        <small class="text-muted">{{ $contact['description'] }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                @if(isset($socialMedia) && count($socialMedia) > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-4">Мы в социальных сетях</h2>
                        <div class="row g-3">
                            @foreach($socialMedia as $social)
                            <div class="col-md-4">
                                <a href="{{ $social['url'] }}" target="_blank" class="btn btn-outline-{{ $social['color'] }} w-100">
                                    {{ $social['name'] }}
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif


                @if(isset($workingHours))
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-4">Режим работы</h2>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    @foreach($workingHours as $day => $hours)
                                    <tr>
                                        <td class="fw-bold">{{ $day }}</td>
                                        <td class="text-end">{{ $hours }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>


            <div class="col-lg-4">
                <div class="card shadow-sm mb-4 bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Есть вопросы?</h5>
                        <p class="card-text">
                            Мы всегда рады помочь! Свяжитесь с нами любым удобным способом, и мы ответим на все ваши вопросы.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Быстрые ссылки</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                                Вернуться на главную
                            </a>
                            <a href="{{ route('about') }}" class="list-group-item list-group-item-action">
                                Узнать о нас больше
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
