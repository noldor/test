@extends('layouts.app')

@section('content')
    @php
    /** @var \App\Models\Calculation $calculation */
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Результаты расчета</div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Название</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control"
                                           value="{{ $calculation->getAttribute('name') }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="source" class="col-md-4 control-label">Исходный текст</label>

                                <div class="col-md-6">
                                    <textarea id="source" class="form-control" disabled>{{ $calculation->getAttribute('source') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-default" href="{{ route('calculations.index') }}">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection