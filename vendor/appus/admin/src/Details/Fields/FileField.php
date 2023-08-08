<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 31.10.2019
 */

namespace Appus\Admin\Details\Fields;

use Appus\Admin\Fields\FieldAbstract;
use Appus\Admin\Fields\FieldInterface;

class FileField extends FieldAbstract
{

    protected $absoluteUrl;

    protected $displayWithUrl;

    protected $download;

    /**
     * @param string|null $value
     * @return string
     */
    public function getRowViewForString(string $value = null): string
    {

        if (!$this->isAbsoluteUrl() && !empty($value)) {
            $value = \Storage::url($value);
        }
        return $this->getView($value);
    }

    /**
     * @param array|null $value
     * @return string|null
     */
    public function getRowViewForArray(array $value = null): ?string
    {
        if (null === $value) {
            return $this->getRowViewForString(null);
        }
        if (!$this->isAbsoluteUrl()) {
            foreach ($value as &$row) {
                $row = \Storage::url($row);
            }
            unset($row);
        }
        return $this->getView($value);
    }

    /**
     * @param null $value
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView($value = null)
    {
        return view('admin::details.fields.file')->with([
            'name' => $this->name,
            'value' => $value,
            'downloadable' => $this->isDownloadable(),
            'ext' => $this->getExtension($value),
            'displayWithUrl' => $this->isDisplayWithUrl(),
        ]);
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function absoluteUrl(bool $value = false): FieldInterface
    {
        $this->absoluteUrl = $value;
        return $this;
    }

    /**
     * @param bool $value
     * @return FieldInterface
     */
    public function displayWithUrl(bool $value = false): FieldInterface
    {
        $this->displayWithUrl = $value;
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
     * @return bool
     */
    protected function isAbsoluteUrl(): bool
    {
        if (null === $this->absoluteUrl) {
            $this->absoluteUrl();
        }
        return $this->absoluteUrl;
    }

    /**
     * @return bool
     */
    protected function isDisplayWithUrl(): bool
    {
        if (null === $this->displayWithUrl) {
            $this->displayWithUrl();
        }
        return $this->displayWithUrl;
    }

    /**
     * @return bool
     */
    protected function isDownloadable(): bool
    {
        if (null === $this->download) {
            $this->download();
        }
        return $this->download;
    }

    /**
     * @param null $path
     * @return mixed|null
     */
    private function getExtension($path = null)
    {
        if (null === $path) {
            return null;
        }
        if (!is_array($path)) {
            return $this->parseExtension($path);
        }
        foreach ($path as &$row) {
            $row = $this->parseExtension($row);
        }
        unset($row);
        return $path;
    }

    /**
     * @param string $path
     * @return string
     */
    private function parseExtension(string $path): string
    {
        $path = explode('.', $path);
        return $path[max(array_keys($path))];
    }

}
