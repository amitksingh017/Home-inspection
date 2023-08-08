<?php

namespace App\Http\Controllers\Admins;

use App\Models\Region;
use Appus\Admin\Details\Details;
use Appus\Admin\Http\Controllers\AdminController;
use Appus\Admin\Form\Form;
use Appus\Admin\Table\Table;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\HtmlConverter;
use function Dotenv\Util\Str;

class RegionController extends AdminController
{

    public function grid(): Table
    {
        $table = new Table(new Region());

        $table->setSubtitle('Regions')
            ->defaultSort('updated_at', 'desc');

        $table->column('id', '#')->searchable(true)->sortable(true);
        $table->column('name', 'Name')->searchable(true)->sortable(true);
        $table->column('short_description', 'Short Description')->displayAs(function ($row){
            return Str::limit($row->short_description, 100, "...");
        })->searchable(true)->sortable(true);

        $table->editAction()
            ->route('regions.edit')
            ->field('region');

        $table->deleteAction()->disabled(true);
        $table->disableMultiDelete();

        $table->css(['/css/region_tab.css']);

        return $table;
    }

    public function details(): Details
    {
        $details = new Details(new Region());

        $details->field('id', 'ID');
        $details->field('name', 'Name');
        $details->field('short_description', 'Short Description');
        $details->field('text', 'Text');

        $details->viewPrepend('button.back', ['route' => 'regions.index']);

        return $details;
    }

    public function form(): Form
    {
        $form = new Form(new Region());

        $form->string('name', 'Name')->rules('required');
        $form->string('short_description', 'Short Description');
        $form->textEditor('text', 'Text');


        $form->redirectWhenCreated('regions.index');
        $form->redirectWhenUpdated('regions.index');

        $form->viewPrepend('button.back', ['route' => 'regions.index']);

        return $form;
    }

    public function update()
    {
        $validatedData = request()->validate([
            'name'  => ['required', 'min:3', 'max:100'],
            'short_description'  => ['nullable', 'string', 'max:250'],
            'text'  => ['nullable', 'string']
        ]);

        if (!empty($validatedData['text'])){
            $converter = new HtmlConverter();
            $validatedData['text'] = $converter->convert($validatedData['text']);

            $arrayQueryString = explode('/', request()->path());
            $modelId = array_pop($arrayQueryString);
            Region::query()->find($modelId)->update($validatedData);
        }

        return $this->form()->save();
    }
}
