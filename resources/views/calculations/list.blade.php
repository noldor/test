@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Название</th>
                            @if($user->isAdmin())
                                <th>Пользователь</th>@endif
                            <th>Коды</th>
                            <th>Дата добавления</th>
                            <th>Дата редактирования</th>
                            <th>Действие</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td colspan="@if($user->isAdmin()) 5 @else 4 @endif">
                                {{ $calculations->links() }}
                            </td>
                            <td class="text-right footer-buttons"><a href="{{ route('calculations.create') }}"
                                                                     class="btn btn-success">Добавить</a></td>
                        </tr>
                        </tfoot>
                        <tbody>
                        @each('calculations.row', $calculations, 'calculation', 'calculations.empty')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection