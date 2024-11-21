<?php

namespace App\Form;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Psr\Clock\ClockInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Ulid;

final readonly class ItemHandler
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private ItemRepository $itemRepository,
        private ClockInterface $clock,
    ) {
    }

    /**
     * @param array<string, mixed> $options
     */
    public function prepare(null|ItemData $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->create(ItemType::class, $data, $options);
    }

    public function handle(FormInterface $form, Request $request): null|false|Item
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ItemData $data */
            $data = $form->getData();
            $item = new Item(
                Ulid::generate(),
                $data->name,
                $this->clock->now(),
            );
            $this->itemRepository->save($item);

            return $item;
        }

        return $form->isSubmitted() ? false : null;
    }
}
