<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 25.10.2019
 */

namespace Appus\Admin\Table\Actions;

use Appus\Admin\Exceptions\InvalidFormatException;

interface ActionInterface
{

    /**
     * @param string $name
     * @return ActionInterface
     */
    public function name(string $name): ActionInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $view
     * @return ActionInterface
     */
    public function asView(string $value): ActionInterface;

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function asHtml(string $value): ActionInterface;

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function route(string $value): ActionInterface;

    /**
     * @param string $value
     * @return ActionInterface
     */
    public function field(string $value): ActionInterface;

    /**
     * @param array $params
     * @return ActionInterface
     */
    public function params(array $params = []): ActionInterface;

    /**
     * @param null $row
     * @return null|string
     */
    public function getUrl($row = null): ?string;

    /**
     * @param bool $value
     * @return ActionInterface
     */
    public function disabled(bool $value = false): ActionInterface;

    /**
     * @param $value
     * @return ActionInterface
     * @throws InvalidFormatException
     */
    public function cssClasses($value): ActionInterface;

    /**
     * @return string
     */
    public function getCssClasses(): string;

    /**
     * @return string
     */
    public function render(): string;

}
