<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Compilation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CompilationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Compilation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            IntegerField::new('priority'),
            BooleanField::new('published')->renderAsSwitch(false),
            AssociationField::new('books')->onlyOnForms(),
            CollectionField::new('books')->onlyOnDetail()
                ->formatValue(
                    function ($value, $entity) {
                        /** @var Book[] $books */
                        $books     = $entity->getBooks();
                        $bookNames = [];

                        foreach ($books as $book) {
                            $url = $this->container->get(AdminUrlGenerator::class)
                                                   ->setController(BookCrudController::class)
                                                   ->setAction(Action::DETAIL)
                                                   ->setEntityId($book->getSlug())
                                                   ->generateUrl();

                            $bookNames[] = '<a href="' . $url . '">' . $book . '</a>';
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
            ->add(TextFilter::new('title'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
                     ->showEntityActionsInlined();
    }
}
