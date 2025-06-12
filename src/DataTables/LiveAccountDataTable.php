<?php

namespace ahmedWeb\LivePlatformManager\DataTables;

use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LiveAccountDataTable extends DataTable
{
    protected $view = 'liveplatform::dashboard.live_account.';
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', $this->view . 'action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LiveAccount $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('liveaccount-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id')->title('#'),
            Column::make('name')->title('Name'),
            Column::make('client_id')->title('Client Id'),
            Column::make('client_secret')->title('Client Secret'),
            Column::make('account_id')->title('Account Id'),
            Column::make('sdk_key')->title('SDK Key'),
            Column::make('sdk_secret')->title('SDK Secret'),
            Column::make('integeration_type')->title('Integeration Type'),
            Column::make('join_url')->title('Join Url'),
            Column::computed('action')
                ->title('Action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LiveAccount_' . date('YmdHis');
    }
}
