<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 15.11.2019
 */

namespace Appus\Admin\Cards;

class Card
{

    protected $item;
    protected $mainItem;

    public function __construct(CardInterface $item, CardInterface $mainItem)
    {
        $this->item = $item;
        $this->mainItem = $mainItem;
    }

    /**
     * @return CardInterface
     */
    public function getItem(): CardInterface
    {
        return $this->item;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->item->initCardBeforeRender($this->mainItem)
            ->render(false, $this->item->getCardView());
    }

    /**
     * @param int $value
     * @return Card
     */
    public function width(int $value): Card
    {
        $this->item->setWidth($value);
        return $this;
    }

}
