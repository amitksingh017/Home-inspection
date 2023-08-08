<?php

namespace App\Http\Controllers\Admins;

use App\Enum\StatusTypeEnum;
use App\Http\Requests\Web\PasswordUpdateRequest;
use App\Models\Inspector;
use App\Rules\CheckEmailLowercase;
use App\Rules\PasswordInspectorRule;
use Appus\Admin\Details\Details;
use Appus\Admin\Http\Controllers\AdminController;
use Appus\Admin\Form\Form;
use Appus\Admin\Messages\Facades\Message;
use Appus\Admin\Table\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InspectorController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Inspector());

        $table->setSubtitle('Inspectors')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->sortable(true);
        $table->column('first_name', 'Name')->searchable(true)->sortable(true);
        $table->column('last_name', 'Last name')->searchable(true)->sortable(true);
        $table->column('email', 'Email')->searchable(true)->sortable(true);
        $table->column('created_at', 'Registration Date')->sortable(true);
        $table->column('region.name', 'Region')->sortable(true);
        $table->column('status', 'Status')->valueAs(function ($row) {
            return StatusTypeEnum::getStringTypeStatus($row->status);
        })->searchable(true);

        $table->customRowAction()
            ->name('Report')
            ->asHtml('<i class="fa fa-file"></i>')
            ->route('reports.index')
            ->field('inspector');

        $table->editAction()
            ->route('inspectors.edit')
            ->field('inspector');

        $table->css(['/css/inspector_tab.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Inspector());

        $details->field('id', 'ID');
        $details->field('first_name', 'First Name');
        $details->field('last_name', 'Last Name');
        $details->field('email', 'Email');
        $details->field('created_at', 'Registration Date');
        $details->field('region.name', 'Region');
        $details->field('status', 'Status')->valueAs(function ($row) {
            return StatusTypeEnum::getStringTypeStatus($row->status);
        });

        $details->viewPrepend('button.back', ['route' => 'inspectors.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Inspector());

        $form->string('first_name', 'First Name')->rules('required');
        $form->string('last_name', 'Last Name')->rules('required');

        $form->string('email', 'Email')->rules(['required','email', new CheckEmailLowercase($form->model()->id)]);
        $form->select('region_id', 'Region')->options(
            $query = (new Inspector)->getListName()
        )->rules('required', 'exists:regions,id');

        if(!$form->model()->id){
            $form->string('password', 'Password')->saveAs(function () {
                    return Hash::make(request()->get('password'));
                })->creationRules(['required', 'min:8', 'max:20', 'confirmed', new PasswordInspectorRule()]);

            $form->string('password_confirmation', 'Password Confirmation')->rules('required|min:8|max:20');
        }
        $form->select('status', 'Status')->options([
            '0' => StatusTypeEnum::INACTIVE,
            '1' => StatusTypeEnum::ACTIVE,
        ]);


        $form->redirectWhenCreated('inspectors.index');
        $form->redirectWhenUpdated('inspectors.index');

        $form->viewPrepend('button.back', ['route' => 'inspectors.index']);

        return $form;
    }
    public function updatePassword(Inspector $inspector)
    {
        return view('inspector.change_password', compact('inspector'));
    }

    public function changePassword(PasswordUpdateRequest $request, Inspector $inspector)
    {
        if (Hash::check($request->current_password, $inspector->password)) {
            $inspector->update(['password'=> Hash::make($request->password)]);
            Message::success('User profile was successfully updated!');

            return redirect()->route('inspectors.index');
        }

        Message::warning('Current password is incorrect');

        return redirect()->back();
    }
}
