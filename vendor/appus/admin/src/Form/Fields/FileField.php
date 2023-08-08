<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 09.01.2020
 */

namespace Appus\Admin\Form\Fields;

use Appus\Admin\Fields\FieldInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class FileField extends FieldAbstract
{

    protected $disk;
    protected $folder;
    protected $fileName;
    protected $originalName;
    protected $download = false;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {
        $value = $value ? \Storage::disk($this->getDisk())->url($value) : null;

        return view('admin::form.fields.file')->with([
            'name' => $this->name,
            'field' => $this->field,
            'value' => $value,
            'validationName' => $this->getFieldForSave(),
            'ext' => $value ? $this->getExtension($value) : '',
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
     * @param string $value
     * @return FieldInterface
     */
    public function disk(string $value): FieldInterface
    {
        $this->disk = $value;
        return $this;
    }

    /**
     * @param $value
     * @return FieldInterface
     * @throws \Exception
     */
    public function name($value): FieldInterface
    {
        if (!is_string($value) && !$value instanceof \Closure) {
            throw new \Exception('Argument must be a string or instance of Closure');
        }
        if (is_string($value)) {
            $this->fileName = $value;
            return $this;
        }
        $this->fileName = $value();
        return $this;
    }

    /**
     * @param string $value
     * @return FieldInterface
     */
    public function folder(string $value = ''): FieldInterface
    {
        $this->folder = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function originalName(bool $value = false): FieldInterface
    {
        $this->originalName = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function download(bool $value = true): FieldInterface
    {
        $this->download = $value;

        return $this;
    }

    /**
     * @return string
     */
    protected function getDisk(): string
    {
        if (null === $this->disk) {
            $this->disk = config('filesystems.default');
        }
        return $this->disk;
    }

    /**
     * @return string
     */
    protected function getFolder(): string
    {
        if (null === $this->folder) {
            $this->folder();
        }
        return $this->folder;
    }

    /**
     * @return bool
     */
    protected function isOriginalName(): bool
    {
        if (null === $this->originalName) {
            $this->originalName();
        }
        return $this->originalName;
    }

    /**
     * @param UploadedFile $file
     * @return string|null
     */
    protected function getFileName(UploadedFile $file): ?string
    {
        if ($this->isOriginalName()) {
            return $file->getClientOriginalName();
        }
        if (null !== $this->fileName) {
            return $this->fileName . '.' . $file->getClientOriginalExtension();
        }
        return $this->fileName;
    }

    /**
     * @param string $path
     * @return string|null
     */
    protected function getExtension(string $path): ?string
    {
        if (!stristr($path, '.')) {
            return null;
        }
        $res = explode('.', $path);
        return array_pop($res);
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
        $field = $this->getFieldForSave();
        $file = request()->file($field);
        if (null === $file) {
            $deleteFileKey = $field . '__delete';
            $deleteFile = request()->get($deleteFileKey);
            if (!empty($deleteFile)) {
                $this->deleteOldFile($model->{$field} ?? null);
                request()->request->remove($deleteFileKey);
                request()->merge([$field => null]);
                return parent::save($model);
            }
            return [];
        }
        $this->deleteOldFile($model->{$field} ?? null);
        $path = $this->saveFile($file);
        request()->merge([$field => $path]);
        return parent::save($model);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function saveFile(UploadedFile $file): string
    {
        $disk = $this->getDisk();
        $folder = $this->getFolder();
        $fileName = $this->getFileName($file);
        if (null === $fileName) {
            return $file->store($folder, $disk);
        }
        return $file->storeAs($folder, $fileName, $disk);
    }

    /**
     * @param string|null $path
     * @return bool
     */
    protected function deleteOldFile(string $path = null): bool
    {
        if (null === $path) {
            return true;
        }
        if (\Storage::disk($this->getDisk())->exists($path)) {
            \Storage::disk($this->getDisk())->delete($path);
        }
        return true;
    }

}
