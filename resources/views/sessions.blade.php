@extends('layout')

@section('content')

<div>
    <h3 class="title mb-4">Sesiones</h3>
    @foreach ($sessions as $classIndex => $groups)
    @foreach ($groups as $groupIndex => $items)
    <div class="card border-primary mb-4">
        <div class="card-header border-primary">
            <h5 class="card-title text-primary font-weight-bold">Aula {{ $classIndex }} - Grupo {{ $groupIndex }}</h5>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($items as $session)
                <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                    <div class="card border-success">
                        <div class="card-body">
                            <h6 class="card-title font-weight-bold">
                                {{ date('d/m/Y', strtotime($session->calendar_date_ini)) }}</h6>

                            <div class="border">
                                <p class="cart-text">
                                    <strong>{{ date('l', strtotime($session->calendar_date_ini)) }}</strong>
                                    {{ date('H:i', strtotime($session->calendar_date_ini)) }} -
                                    {{ date('H:i', strtotime($session->calendar_date_end)) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    @endforeach
</div>

@endsection
