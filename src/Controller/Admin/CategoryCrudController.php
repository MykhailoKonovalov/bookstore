<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updatedAt')->onlyOnDetail(),
            CollectionField::new('books')->onlyOnDetail()
                ->formatValue(function ($value, $entity) {
                    /** @var Book[] $books */
                    $books     = $entity->getBooks();
                    $bookNames = [];

                    foreach ($books as $book) {
                        $url = $this->container->get(AdminUrlGenerator::class)
                                               ->setController(BookCrudController::class)
                                               ->setAction(Action::DETAIL)
                                               ->setEntityId($book->getSlug())
                                               ->generateUrl();

                        $bookNames[] = '<a href="' . $url . '">' . $book->getTitle() . '</a>';
                    }

                    return implode(', </br>', $bookNames);
                },
            ),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('name'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
                     ->showEntityActionsInlined();
    }
}
