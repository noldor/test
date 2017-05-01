<tr id="calculation-{{ $calculation->getAttribute('id') }}">
    <td>{{ $calculation->getAttribute('name') }}</td>
    @if($user->isAdmin())
        <td>{{ $calculation->user->name }}</td>@endif
    @if (!is_null($calculation->getAttribute('secreteCodes')))
    <td>
        @foreach($calculation->secreteCodes as $code)
            <span class="label label-default">{{ $code->value }}</span>
        @endforeach
    </td>
    @endif
    <td title="{{ $calculation->getAttribute('created_at') }}">{{ $calculation->getAttribute('created_at')->diffForHumans() }}</td>
    <td title="{{ $calculation->getAttribute('updated_at') }}">{{ $calculation->getAttribute('updated_at')->diffForHumans() }}</td>
    <td>
        <div class="btn-group pull-right" role="group">
            <a class="btn btn-default"
               href="{{ route('calculations.show', [$calculation->getAttribute('id')]) }}">Посмотреть</a>
            <a class="btn btn-default"
               href="{{ route('calculations.edit', [$calculation->getAttribute('id')]) }}">Обновить</a>
            <button type="button" class="btn btn-default calculation-delete"
                    data-id="{{ $calculation->getAttribute('id') }}">Удалить
            </button>
        </div>
    </td>
</tr>