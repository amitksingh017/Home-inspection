<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 18.11.2019
 */

namespace Appus\Admin\Cards;

use Appus\Admin\Details\Traits\CardDetailsTrait;
use Appus\Admin\Table\Traits\CardTableTrait;
use Illuminate\Database\Eloquent\Model;

trait CardsTrait
{

    use CardDetailsTrait, CardTableTrait;

    protected $cards;

    protected $width;

    /**
     * @param \Closure $callback
     * @param Model|null $model
     * @param string|null $hash
     * @return Card
     */
    public function card(\Closure $callback, Model $model = null, string $hash = null): Card
    {
        $className = __CLASS__;
        return $this->initCard($className, $callback, $model, $hash);
    }

    /**
     * @param CardInterface $mainItem
     * @return $this
     */
    public function initCardBeforeRender(CardInterface $mainItem)
    {
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setWidth(int $value)
    {
        $this->width = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return md5(get_class($this->model));
    }

    /**
     * @param string $className
     * @param \Closure $callback
     * @param Model|null $model
     * @param string|null $hash
     * @return Card
     */
    protected function initCard(string $className, \Closure $callback, Model $model = null, string $hash = null): Card
    {
        $item = app($className, ['model' => $model ?? $this->model]);
        $callback($item);
        $card = new Card($item, $this);
        $this->cards[$hash ?? $item->getHash()] = $card;
        return $card;
    }

    /**
     * @return array|null
     */
    protected function getCards(): ?array
    {
        return $this->cards;
    }

}
