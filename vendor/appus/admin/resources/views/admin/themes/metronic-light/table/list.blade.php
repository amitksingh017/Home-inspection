<table class="kt-datatable__table" style="display: block;">
    <thead class="kt-datatable__head">
    <tr class="kt-datatable__row" style="left: 0px;">
        <th class="kt-datatable__cell--center kt-datatable__cell kt-datatable__cell--check">
            @if($data->count() > 0 && isset($data->first()->id) && $multiActions)
                <span style="width: 20px;">
                    <label class="kt-checkbox kt-checkbox--single kt-checkbox--all kt-checkbox--solid">
                        <input type="checkbox">
                        <span></span>
                    </label>
                </span>
            @endif
        </th>
        @foreach($columns as $column)
            <th data-field="{{ $column->getField() }}"
                class="kt-datatable__cell @if($column->isSortable()) kt-datatable__cell--sort @endif  @if($column->isSearchable()) searchable @endif"
                @if($column->isSortable()) data-sort-field="{{ $column->getField() }}" data-current-direction="{{ $column->getSort() }}" @endif
            >
                <span style="width: 202px;">
                    {{ $column->getName() }}
                    @if($column->isSortable())
                        @if('asc' === $column->getSort())
                            <i class="fas fa-sort-up"></i>
                        @elseif('desc' === $column->getSort())
                            <i class="fas fa-sort-down"></i>
                        @else
                            <i class="fas fa-sort"></i>
                        @endif
                    @endif
                </span>
            </th>
        @endforeach
        <th class="kt-datatable__cell actions">Actions</th>
    </tr>
    </thead>
    <tbody class="kt-datatable__body">
        @if($data->count() > 0)
            @foreach($data as $row)
                <tr data-row="0" class="kt-datatable__row" style="left: 0px;">
                    <td class="kt-datatable__cell--center kt-datatable__cell kt-datatable__cell--check">
                        @if(isset($row->id) && $multiActions)
                            <span style="width: 20px;">
                                <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                    <input type="checkbox" name="ids[]" class="checkbox-row" value="{{ $row->id }}">
                                    <span></span>
                                </label>
                            </span>
                        @endif
                    </td>
                    <?php $additionalRowsForColumns = []; ?>
                    @foreach($columns as $column)
                        <td class="kt-datatable__cell--sorted kt-datatable__cell additional-button-container" data-field="{{ $column->getField() }}">
                            <span style="width: 202px;">
                                @if($column->hasAdditionalRow() || $column->hasAdditionalModal())

                                    <?php $additionalRowsForColumns[] = $column; ?>

                                    <a href="#"
                                       class="additional-button @if($column->hasAdditionalRow()) additional-row-button @endif @if($column->hasAdditionalModal()) additional-modal-button @endif"
                                       title="Click to view information"
                                       data-index="{{ $loop->parent->index }}"
                                    >
                                        {!! $column->getCell($row) !!}
                                    </a>
                                @else
                                    {!! $column->getCell($row) !!}
                                @endif
                            </span>
                        </td>
                    @endforeach
                    <td class="kt-datatable__cell actions">

                        @if ($rowActions)
                            @if($isHiddenRowActions)
                                <span style="overflow: visible; position: relative; width: 80px;">
                                    <div class="dropdown">
                                        <a data-toggle="dropdown" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="flaticon-more-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="kt-nav">
                                                @foreach($rowActions as $action)
                                                    @if(!$action->isDisabled())
                                                        <li class="kt-nav__item">
                                                            <a
                                                                class="kt-nav__link  {{ $action->getCssClasses() }}"
                                                                @if($action->getUrl($row))
                                                                    href="{{ $action->getUrl($row) }}"
                                                                @endif
                                                                @if(isset($row->id))
                                                                    data-id="{{ $row->id }}"
                                                                @endif
                                                            >
                                                                {!! $action->render() !!}
                                                                <span class="kt-nav__link-text">{{ $action->getName() }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </span>
                            @else
                                @foreach($rowActions as $action)
                                    @if(!$action->isDisabled())
                                        <a
                                            class="action {{ $action->getCssClasses() }}"
                                            @if($action->getUrl($row))
                                                href="{{ $action->getUrl($row) }}"
                                            @endif
                                            title="{{ $action->getName() }}"
                                            @if(isset($row->id))
                                                data-id="{{ $row->id }}"
                                            @endif
                                        >
                                            {!! $action->render() !!}
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        @endif

                    </td>
                </tr>
                @if (!empty($additionalRowsForColumns))
                    @foreach($additionalRowsForColumns as $additionalRowForColumn)
                        @if($additionalRowForColumn->hasAdditionalRow())
                            <tr class="additional-row" data-field="{{ $additionalRowForColumn->getField() }}" data-index="{{ $loop->parent->index }}">
                                <td colspan="{{ count($columns) + 2 }}">
                                    {!! $additionalRowForColumn->getAdditionalRow($row) !!}
                                </td>
                            </tr>
                        @endif
                        @if($additionalRowForColumn->hasAdditionalModal())
                            <tr class="additional-modal" data-field="{{ $additionalRowForColumn->getField() }}" data-index="{{ $loop->parent->index }}">
                                <td colspan="{{ count($columns) + 2 }}">
                                    <div class="additional-modal-window">
                                        {!! $additionalRowForColumn->getAdditionalModal($row) !!}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @else
            <tr class="kt-datatable__row">
                <td
                    class="kt-datatable__cell--center kt-datatable__cell"
                    colspan="{{ count($columns) + 2 }}"
                    style="padding: 30px; font-size: 20px;"
                >
                    <span class="kt-datatable--error">
                        @if(request()->get('search'))
                            No search results found
                        @else
                            No records found
                        @endif
                    </span>
                </td>
            </tr>
        @endif
    </tbody>
</table>

@if(!$disabledPagination)
    {{ $data->links('admin::table.pagination')->with(['itemPerPageOptions' => $itemPerPageOptions]) }}
@endif
