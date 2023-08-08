<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 23.01.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Fields\FieldInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ImageField extends FileField
{

    protected $cropper;

    protected $cropperRatio;

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function cropper(bool $value = false): FieldInterface
    {
        $this->cropper = $value;
        return $this;
    }

    /**
     * @param float $value
     * @return FieldInterface
     */
    public function cropperRatio(float $value): FieldInterface
    {
        $this->cropperRatio = $value;
        return $this;
    }

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        $value = $value ? \Storage::disk($this->getDisk())->url($value) : null;

        return view('admin::form.fields.image')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'ext' => $value ? $this->getExtension($value) : '',
            'cropper' => $this->isCropper(),
            'cropperRatio' => $this->cropperRatio,
            'help' => $this->help,
            'downloadable' => $this->download,
        ]);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        return null;
    }

    /**
     * @param Model $model
     * @return array
     * @throws \Appus\Admin\Exceptions\UnknownRelationException
     */
    public function save(Model $model): array
    {
        if (null !== $this->saveAs) {
            return parent::save($model);
        }
        if (!$this->isCropper()) {
            return parent::save($model);
        }
        $field = $this->getFieldForSave();
        $file = request()->get($field);
        if (null === $file) {
            return parent::save($model);
        }
        $this->deleteOldFile($model->{$field} ?? null);
        $path = $this->getFolder() . '/' . ($this->fileName ?? md5(uniqid('', true) . date('Y-m-d H:i:s')));
        \Storage::disk($this->getDisk())->put($path, $this->parseBase64($file));
        request()->merge([$field => $path]);
        return $this->defaultSave($model, $field);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function parseBase64(string $string): string
    {
        $string = stristr($string, ';base64,');
        $string = str_replace(';base64,', '', $string);
        return base64_decode($string);
    }

    /**
     * @return bool
     */
    protected function isCropper(): bool
    {
        if (null === $this->cropper) {
            $this->cropper();
        }
        return $this->cropper;
    }

}
