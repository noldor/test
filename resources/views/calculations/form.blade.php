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
                        <div class="alert alert-danger hidden show">
                            <ul id="errors-list">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <form id="main-form" class="form-horizontal" role="form" method="POST" action="{{ $action }}">
                            {{ method_field($method) }}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Название</label>

                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" class="form-control"
                                           value="{{ isset($calculation) ? $calculation->getAttribute('name') : old('name') }}"
                                           required autofocus>
                                </div>
                            </div>

                            @if (
                                isset($calculation) &&
                                !is_null($calculation->getAttribute('secretCodes')) &&
                                !$calculation->getAttribute('secretCodes')->isEmpty()
                            )
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Коды</label>

                                    <div class="col-sm-6">
                                        @foreach($calculation->getAttribute('secretCodes') as $code)
                                            <span class="label label-default">{{ $code->value }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
                                <label for="source" class="col-md-4 control-label">Исходный текст</label>

                                <div class="col-md-6">
                                    <textarea id="source" class="form-control"
                                              @if(isset($disableSource) && $disableSource === true)
                                              disabled @else name="source"
                                              required @endif>{{ isset($calculation) ? $calculation->getAttribute('source') : old('source')}}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer text-right">
                        <div class="btn-group" role="group">
                            <a class="btn btn-default" href="{{ route('calculations.index') }}">Назад</a>
                            <button type="button" class="btn btn-success" id="calculation-save">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection