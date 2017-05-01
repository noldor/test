<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Фильтры</h3>
            </div>
            <div class="panel-body">
                <form id="filters" method="get" action="{{ route('calculations.index') }}">
                    @forelse($filters as $filter)
                        <div class="col-sm-4 filter-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select name="types[]" class="form-control types-input">
                                                <option value="=" @if($filter['type'] === '=') selected @endif>=
                                                </option>
                                                <option value=">" @if($filter['type'] === '>') selected @endif>>
                                                </option>
                                                <option value="<" @if($filter['type'] === '<') selected @endif><
                                                </option>
                                                <option value=">=" @if($filter['type'] === '>=') selected @endif>>=
                                                </option>
                                                <option value="<=" @if($filter['type'] === '<=') selected @endif><=
                                                </option>
                                                <option value="!=" @if($filter['type'] === '!=') selected @endif>!=
                                                </option>
                                                <option value="like" @if($filter['type'] === 'like') selected @endif>
                                                    like
                                                </option>
                                                <option value="not like"
                                                        @if($filter['type'] === 'not like') selected @endif>not like
                                                </option>
                                                <option value="null" @if($filter['type'] === 'null') selected @endif>
                                                    null
                                                </option>
                                                <option value="not null"
                                                        @if($filter['type'] === 'not null') selected @endif>not null
                                                </option>
                                                <option value="regexp"
                                                        @if($filter['type'] === 'regexp') selected @endif>regexp
                                                </option>
                                                <option value="not regexp"
                                                        @if($filter['type'] === 'not regexp') selected @endif>not regexp
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" name="values[]" class="form-control values-input"
                                                   placeholder="Значение" value="{{ $filter['value'] }}">
                                        </div>
                                        <div class="col-sm-1 filter-separator">
                                            <div>И</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-sm-4 filter-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select name="types[]" class="form-control types-input">
                                                <option value="=">=</option>
                                                <option value=">">></option>
                                                <option value="<"><</option>
                                                <option value=">=">>=</option>
                                                <option value="<="><=</option>
                                                <option value="!=">!=</option>
                                                <option value="like">like</option>
                                                <option value="not like">not like</option>
                                                <option value="null">null</option>
                                                <option value="not null">not null</option>
                                                <option value="regexp">regexp</option>
                                                <option value="not regexp">not regexp</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" name="values[]" class="form-control values-input"
                                                   placeholder="Значение">
                                        </div>
                                        <div class="col-sm-1 filter-separator">
                                            <div>И</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    <div class="col-sm-2 button-add-filter">
                        <button type="button" id="add-filter" class="btn btn-info">Добавить</button>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <button type="submit" form="filters" class="btn btn-success">Найти</button>
                <a href="{{ route('calculations.index') }}" class="btn btn-danger">Сбросить</a>
            </div>
        </div>
    </div>
</div>