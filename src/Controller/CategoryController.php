<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name:'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show (
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository ,
        string $categoryName
     ): Response {
        
        $category = $categoryRepository->findOneByName($categoryName);
        
        if(!$category){
            throw $this->createNotFoundException(
                'No category found in category\'s table'
            );
        };

        $programs = $programRepository->findByCategory($category);

        if(!$programs){
            throw $this->createNotFoundException(
                'No series found for ' . $category->getName() . ' category'
            );
        };
        

        return $this->render('category/show.html.twig',[
            'programs' => $programs
        ]);
    }
}
