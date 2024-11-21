<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemHandler;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ItemController extends AbstractController
{
    public function __construct(
        private readonly ItemHandler $itemHandler,
        private readonly ItemRepository $itemRepository,
    ){}

    #[Route('/add', name: 'app_add_item', methods: [Request::METHOD_POST])]
    public function addItem(Request $request): Response
    {
        $form = $this->itemHandler->prepare();
        $item = $this->itemHandler->handle($form, $request);

        return match (true) {
            $item instanceof Item => new Response('', Response::HTTP_NO_CONTENT),
            $item === false => new Response('', Response::HTTP_BAD_REQUEST),
            default => new Response('', Response::HTTP_UNPROCESSABLE_ENTITY),
        };
    }

    #[Route('/items/{id}/toggle', name: 'app_toggle', methods: [Request::METHOD_POST])]
    public function toggle(string $id): Response
    {
        $item = $this->itemRepository->findOneById($id);
        if ($item === null) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $item->toggle();
        $this->itemRepository->save($item);
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    #[Route('/items/{id}/remove', name: 'app_remove', methods: [Request::METHOD_POST])]
    public function remove(string $id): Response
    {
        $item = $this->itemRepository->findOneById($id);
        if ($item === null) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        $this->itemRepository->remove($item);

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
