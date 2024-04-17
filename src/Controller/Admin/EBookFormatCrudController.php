<?php

namespace App\Controller\Admin;

use App\Constant\EBookFormats;
use App\Entity\EBookFormat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FormField;

class EBookFormatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EBookFormat::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fileUrl'),
            ChoiceField::new('format')
                ->setChoices(
                    EBookFormats::toArray()
                )->autocomplete(),
        ];
    }
}
