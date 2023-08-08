<?php


namespace App\Http\Controllers\Admins;
use App\Models\Report;
use Appus\Admin\Details\Details;
use Appus\Admin\Form\Form;
use Appus\Admin\Http\Controllers\AdminController;
use Appus\Admin\Table\Table;
use Illuminate\Support\Facades\Storage;


class ReportController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Report());

        $table->setSubtitle('Report')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->sortable(true);
        $table->column('created_at', 'Date of the report creation')->sortable(true);
        $table->column('updated_at', 'Date of the report editing')->sortable(true);
        $table->column('address', 'Address')->searchable(true)->sortable(true);;

        $table->query(function ($query) {
            if ($inspector = request()->get('inspector')) {
                $query->where(function ($q) use ($inspector) {
                    $q->where('inspector_id', 'like', "%$inspector%");
                });
            }
        });

        $table->editAction()->disabled(true);
        $table->deleteAction()->disabled(true);
        $table->viewAction()->disabled(true);
        $table->createAction()->disabled(true);

        $table->customRowAction()
            ->name('Report')
            ->asHtml('<i class="fa fa-file"> Download PDF</i>')
            ->route('report.download')
            ->field('id');

        $table->viewPrepend('button.back', ['route' => 'inspectors.index']);
        $table->css(['/css/report_tab.css']);
        $table->disableMultiDelete();

        return $table;
    }

    public function download($id)
    {
        $report = Report::find($id);

        return Storage::download($report->path);
    }

    public function details(): Details
    {

    }

    public function form(): Form
    {

    }

}